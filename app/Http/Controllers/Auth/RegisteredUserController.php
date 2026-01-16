<?php

namespace App\Http\Controllers\Auth;

use App\Enums\KYCStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Events\UserReferred;
use App\Facades\Txn\Txn;
use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Models\LoginActivities;
use App\Models\ReferralLink;
use App\Models\User;
use App\Models\UserKyc;
use App\Rules\Recaptcha;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    use ImageUpload, NotifyTrait;

    public function create(Request $request)
    {
        if (!setting('account_creation', 'permission')) {
            abort('403', __('User registration is closed now'));
        }

        $page = getPageData('registration');
        $data = json_decode($page?->data, true);

        $location = getLocation();
        $referralCode = ReferralLink::find($request->cookie('invite'))?->code ?? $request->get('invite');
        $sellerKyc = setting('seller_register_kyc', 'permission') ? Kyc::sellerVerification()->first() : null;

        $googleReCaptcha = plugin_active('Google reCaptcha');
        $googleReCaptchaData = $googleReCaptcha ? json_decode($googleReCaptcha->data, true) : [];
        $googleReCaptchaKey = $googleReCaptchaData['site_key'] ?? $googleReCaptchaData['google_recaptcha_key'] ?? null;

        return view('frontend::auth.register', compact('location', 'referralCode', 'data', 'sellerKyc', 'googleReCaptcha', 'googleReCaptchaKey'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {

        $userType = $request->get('user_type', 'buyer');
        $prefix = $userType === 'seller' ? 'seller_' : '';

        $isFirstName = (bool) getPageSetting($prefix . 'first_name_validation') && getPageSetting($prefix . 'first_name_show');
        $isLastName = (bool) getPageSetting($prefix . 'last_name_validation') && getPageSetting($prefix . 'last_name_show');
        $isCountry = (bool) getPageSetting($prefix . 'country_validation') && getPageSetting($prefix . 'country_show');
        $isPhone = (bool) getPageSetting($prefix . 'phone_validation') && getPageSetting($prefix . 'phone_show');
        $isGender = (bool) getPageSetting($prefix . 'gender_validation') && getPageSetting($prefix . 'gender_show');
        $isReferralCode = (bool) getPageSetting($prefix . 'referral_code_validation') && getPageSetting($prefix . 'referral_code_show');

        $request->validate([
            'first_name' => [Rule::requiredIf($isFirstName), 'string', 'max:255'],
            'last_name' => [Rule::requiredIf($isLastName), 'string', 'max:255'],
            'g-recaptcha-response' => Rule::requiredIf(plugin_active('Google reCaptcha')),
            new Recaptcha,
            'gender' => [Rule::requiredIf($isGender), 'in:male,female,other'],
            'username' => ['required', 'string', 'max:17', 'unique:users'],
            'country' => [Rule::requiredIf($isCountry), 'string', 'max:255'],
            'phone' => [Rule::requiredIf($isPhone), 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'invite' => [Rule::requiredIf($isReferralCode), 'exists:referral_links,code'],
            'user_type' => 'required|in:seller,buyer',
            'terms' => 'required|accepted',
        ], [
            'invite.required' => __('Referral code field is required.'),
            'invite.exists' => __('Referral code is invalid'),
        ]);

        $location = getLocation();
        $phoneWithCountryCode = explode(':', $request->get('country', ''));
        $phone = data_get($phoneWithCountryCode, '1', $location->dial_code) . $request->get('phone');
        $country = $isCountry ? explode(':', $request->get('country'))[0] : $location->name;

        $request->merge([
            'country' => $country,
            'phone' => $phone,
        ]);

        try {
            $user = $this->register($request);
            $this->sellerKycSubmit($request, $user);
        } catch (\Throwable $th) {
            // throw $th;
            notify()->error(__('Something went wrong!'), __('Registration failed!'));
            DB::rollBack();
        }

        DB::commit();

        if (session('checkout')) {
            return to_route('checkout');
        }

        if (isset($user) && !$user->is_seller) {
            return to_route('home');
        }

        return to_route('user.dashboard');
    }

    public function register(Request $request)
    {

        $userType = $request->get('user_type', 'buyer');
        $userData = [
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'gender' => $request->get('gender'),
            'username' => str($request->get('username'))->slug()->value(),
            'country' => $request->country,
            'phone' => $request->phone,
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'user_type' => $userType,
        ];

        if ($request->has('from_social')) {
            // check kyc as per user type if any kyc needed
            if ($userType === 'seller' && setting('seller_register_kyc', 'permission') && Kyc::whereIn('user_type', ['seller', 'both'])->exists()) {
                $kycStatus = KYCStatus::NOT_SUBMITTED;
            } elseif ($userType === 'buyer' && Kyc::whereIn('user_type', ['buyer', 'both'])->exists()) {
                $kycStatus = KYCStatus::NOT_SUBMITTED;
            } else {
                $kycStatus = KYCStatus::Verified;
            }

            $userData['kyc'] = $kycStatus ?? KYCStatus::NOT_SUBMITTED;
        }

        $user = User::create($userData);

        $shortcodes = [
            '[[full_name]]' => $request->get('first_name') . ' ' . $request->get('last_name'),
        ];

        // Notify user and admin
        $this->pushNotify('new_user', $shortcodes, route('admin.user.edit', $user->id), $user->id, 'Admin');
        $this->pushNotify('new_user', $shortcodes, null, $user->id);
        $this->smsNotify('new_user', $shortcodes, $user->phone);

        // Referred event
        event(new UserReferred($request->cookie('invite'), $user));

        if (setting('email_verification', 'permission') && !$request->has('from_social')) {
            $user->sendEmailVerificationNotification();
        }

        if (setting('referral_signup_bonus', 'permission') && (float) setting('signup_bonus', 'fee') > 0) {
            $signupBonus = (float) setting('signup_bonus', 'fee');
            $user->increment('balance', $signupBonus);
            (new Txn)->new($signupBonus, 0, $signupBonus, 'system', 'Signup Bonus', TxnType::SignupBonus, TxnStatus::Success, null, null, $user->id);
            Session::put('signup_bonus', $signupBonus);
        }

        Cookie::forget('invite');
        Auth::login($user);
        LoginActivities::add();

        return $user;
    }

    public function sellerKycSubmit(Request $request, User $user)
    {

        // check seller kyc
        if ($request->get('user_type') == 'seller' && setting('seller_register_kyc', 'permission')) {
            $sellerKyc = Kyc::sellerVerification()->first();

            if ($sellerKyc) {

                foreach (json_decode($sellerKyc->fields, true) ?? [] as $key => $field) {
                    if ($field['validation'] == 'required') {
                        $request->validate([
                            'kyc_credential.' . $field['name'] => 'required',
                        ]);
                    }
                }

                $newKycs = $request->kyc_credential;

                foreach ($newKycs as $key => $value) {

                    if (is_file($value)) {
                        $newKycs[$key] = self::imageUploadTrait($value);
                    }
                }

                UserKyc::create([
                    'user_id' => $user->id,
                    'kyc_id' => $sellerKyc->id,
                    'type' => $sellerKyc->name,
                    'data' => $newKycs,
                    'is_valid' => true,
                    'status' => 'pending',
                ]);

                $user->update([
                    'kyc_credential' => null,
                    'kyc' => KYCStatus::Pending,
                ]);

                $shortcodes = [
                    '[[full_name]]' => $user->full_name,
                    '[[email]]' => $user->email,
                    '[[site_title]]' => setting('site_title', 'global'),
                    '[[site_url]]' => route('home'),
                    '[[kyc_type]]' => $user->kyc_type,
                    '[[status]]' => 'Pending',
                ];

                $this->mailNotify(setting('site_email', 'global'), 'kyc_request', $shortcodes);
                $this->pushNotify('kyc_request', $shortcodes, route('admin.kyc.pending'), $user->id, 'Admin');

            }
        }
    }
}
