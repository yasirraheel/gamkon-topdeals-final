<?php

namespace App\Http\Controllers\Backend;

use App\Enums\KYCStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Models\LevelReferral;
use App\Models\Listing;
use App\Models\PlanHistory;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserKyc;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use ImageUpload;
    use NotifyTrait;

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:customer-list|customer-login|customer-mail-send|customer-basic-manage|customer-change-password|all-type-status|customer-balance-add-or-subtract', ['only' => ['index', 'activeUser', 'disabled', 'mailSendAll', 'mailSend']]);
        $this->middleware('permission:customer-basic-manage|customer-change-password|all-type-status|customer-balance-add-or-subtract', ['only' => ['edit']]);
        $this->middleware('permission:customer-login', ['only' => ['userLogin']]);
        $this->middleware('permission:customer-mail-send', ['only' => ['mailSendAll', 'mailSend']]);
        $this->middleware('permission:customer-basic-manage', ['only' => ['update']]);
        $this->middleware('permission:customer-change-password', ['only' => ['passwordUpdate']]);
        $this->middleware('permission:all-type-status', ['only' => ['statusUpdate']]);
        $this->middleware('permission:customer-balance-add-or-subtract', ['only' => ['balanceUpdate']]);
    }

    public function index(Request $request)
    {
        $search = $request->query('query') ?? null;

        $users = User::query()
            ->when(!blank(request('email_status')), function ($query) {
                if (request('email_status')) {
                    $query->whereNotNull('email_verified_at');
                } else {
                    $query->whereNull('email_verified_at');
                }
            })
            ->when(!blank(request('kyc_status')), function ($query) {
                $query->where('kyc', request('kyc_status'));
            })
            ->when(!blank(request('status')), function ($query) {
                $query->where('status', request('status'));
            })
            ->when(!blank(request('type')), function ($query) {
                match (request('type')) {
                    'seller' => $query->where('user_type', 'seller'),
                    'buyer' => $query->where('user_type', 'buyer'),
                    default => null,
                };

            })
            ->when(!blank(request('sort_field')), function ($query) {
                $query->orderBy(request('sort_field'), request('sort_dir'));
            })
            ->when(!request()->has('sort_field'), function ($query) {
                $query->latest();
            })
            ->search($search)
            ->paginate();

        $title = __('All Users');

        return view('backend.user.index', compact('users', 'title'));
    }

    public function sellerUser(Request $request)
    {
        $search = $request->query('query') ?? null;

        $users = User::
            when(!blank(request('email_status')), function ($query) {
                if (request('email_status')) {
                    $query->whereNotNull('email_verified_at');
                } else {
                    $query->whereNull('email_verified_at');
                }
            })
            ->when(!blank(request('kyc_status')), function ($query) {
                $query->where('kyc', request('kyc_status'));
            })
            ->when(!blank(request('status')), function ($query) {
                $query->where('status', request('status'));
            })
            ->when(!blank(request('sort_field')), function ($query) {
                $query->orderBy(request('sort_field'), request('sort_dir'));
            })
            ->when(!request()->has('sort_field'), function ($query) {
                $query->latest();
            })
            ->search($search)
            ->where('user_type', 'seller')
            ->paginate();

        $title = __('Sellers');

        return view('backend.user.index', compact('users', 'title'));
    }

    public function buyerUser(Request $request)
    {
        $search = $request->query('query') ?? null;

        $users = User::
            when(!blank(request('email_status')), function ($query) {
                if (request('email_status')) {
                    $query->whereNotNull('email_verified_at');
                } else {
                    $query->whereNull('email_verified_at');
                }
            })
            ->when(!blank(request('kyc_status')), function ($query) {
                $query->where('kyc', request('kyc_status'));
            })
            ->when(!blank(request('status')), function ($query) {
                $query->where('status', request('status'));
            })
            ->when(!blank(request('sort_field')), function ($query) {
                $query->orderBy(request('sort_field'), request('sort_dir'));
            })
            ->when(!request()->has('sort_field'), function ($query) {
                $query->latest();
            })
            ->search($search)
            ->where('user_type', 'buyer')
            ->paginate();

        $title = __('Buyers');

        return view('backend.user.index', compact('users', 'title'));
    }

    public function create(Request $request, $type = null)
    {
        $userType = $type ?? str(url()->current())->after('add-new/')->value();
        $kycs = Kyc::where('status', true)->when($userType, function ($query) use ($userType) {
            $query->where('user_type', $userType)->orWhere('user_type', 'both');
        })->get();

        return view('backend.user.create', compact('kycs', 'userType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $user = User::withCount(['tickets', 'referrals', 'listings', 'coupons'])->findOrFail($id);
        $level = LevelReferral::where('type', 'investment')->max('the_order') + 1;

        $tab = request('tab');
        $query = request('query');
        $sortField = request('sort_field');
        $sortDir = request('sort_dir') ?? 'desc';

        $earnings = [];
        $transactions = [];
        $listings = $purchases = [];
        $tickets = [];
        $ads_histories = [];
        $ads = [];
        $subscriptions = [];
        match ($tab) {
            'transactions' => $transactions = Transaction::where('user_id', $user->id)
                ->when($query, fn($q) => $q->search($query))
                ->when($sortField, fn($q) => $q->orderBy($sortField, $sortDir), fn($q) => $q->latest())
                ->paginate()
                ->withQueryString(),
            'earnings' => $earnings = Transaction::where('user_id', $user->id)
                ->whereIn('type', [TxnType::Referral, TxnType::ProductSold, TxnType::SignupBonus])
                ->when($query, fn($q) => $q->search($query))
                ->when($sortField, fn($q) => $q->orderBy($sortField, $sortDir), fn($q) => $q->latest())
                ->paginate()
                ->withQueryString(),

            'ticket' => $tickets = Ticket::where('user_id', $user->id)
                ->when($query, fn($q) => $q->where('title', 'LIKE', '%' . $query . '%'))
                ->when(in_array($sortField, ['created_at', 'title', 'status']), fn($q) => $q->orderBy($sortField, $sortDir), fn($q) => $q->latest())
                ->paginate()
                ->withQueryString(),
            'subscriptions' => $subscriptions = PlanHistory::where('user_id', $user->id)->latest()->paginate(),
            'listings' => $listings = Listing::whereBelongsTo($user, 'seller')
                ->when($query, fn($q) => $q->search($query))
                ->latest()->paginate(),
            'purchase' => $purchases = Transaction::own($user)
                ->when($query, fn($q) => $q->search($query))
                ->whereIn('type', [TxnType::ProductOrder, TxnType::ProductOrderViaTopup])->latest()->paginate(),
            default => null,
        };
        $statistics = [
            'total_earnings' => $user->totalProfit(),
            'total_transactions' => $user->transaction->count(),
            'total_topup' => $user->is_seller ? $user->balance : $user->topup_balance,
            'total_withdraw' => $user->totalWithdraw(),
            'total_tickets' => $user->tickets_count,
            'earnings' => $user->totalProfit(),
            'all_referral' => $user->referrals_count,
            'total_listings' => $user->listings_count,
        ];

        return view('backend.user.edit', compact('user', 'level', 'statistics', 'earnings', 'listings', 'transactions', 'tickets', 'purchases', 'ads_histories', 'ads', 'subscriptions'));
    }

    /**
     * @return RedirectResponse
     */
    public function statusUpdate($id, Request $request)
    {
        $input = $request->all();

        $user = User::find($id);
        $validator = Validator::make($input, [
            'status' => 'required',
            'email_verified' => 'required',
            'kyc' => 'required',
            'two_fa' => 'required',
            'deposit_status' => !$user->is_seller ? 'required' : 'nullable',
            'withdraw_status' => 'required',
            'otp_status' => 'required',
            'show_following_follower_list' => $user->is_seller ? 'required' : 'nullable',
            'accept_profile_chat' => $user->is_seller ? 'required' : 'nullable',
            'is_popular' => $user->is_seller ? 'required' : 'nullable',
            'user_type' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $data = [
            'status' => $input['status'],
            'kyc' => $input['kyc'],
            'two_fa' => $input['two_fa'],
            'deposit_status' => $input['deposit_status'] ?? $user->deposit_status,
            'withdraw_status' => $input['withdraw_status'],
            'otp_status' => $input['otp_status'],
            'show_following_follower_list' => $input['show_following_follower_list'] ?? $user->show_following_follower_list,
            'accept_profile_chat' => $input['accept_profile_chat'] ?? $user->show_following_follower_list,
            'email_verified_at' => $input['email_verified'] == 1 ? now() : null,
            'is_popular' => $input['is_popular'] ?? $user->is_popular,
            'user_type' => $input['user_type'],
        ];

        if ($user->status != $input['status'] && !$input['status']) {

            $shortcodes = [
                '[[full_name]]' => $user->full_name,
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
            ];

            $this->mailNotify($user->email, 'user_account_disabled', $shortcodes);
            $this->smsNotify('user_account_disabled', $shortcodes, $user->phone);
        }

        User::find($id)->update($data);

        if (!$input['kyc']) {
            $this->markAsUnverified($id);
        }

        notify()->success(__('Status Updated Successfully'), 'Success');

        return redirect()->back();

    }

    protected function markAsUnverified($user_id)
    {
        UserKyc::where('user_id', $user_id)->where('is_valid', true)->update([
            'is_valid' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'date_of_birth' => 'nullable|date',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6',
            'invite' => 'nullable|exists:referral_links,code',
            'country' => 'required',
            'user_type' => 'required|in:seller,buyer',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back()->withInput();
        }

        $generateUsername = $request->fname . $request->lname;

        $usernameExists = User::where('username', $generateUsername)->exists();

        $user = User::create([
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'username' => !$usernameExists ? strtolower($generateUsername) : strtolower($generateUsername . Str::random(4)),
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'gender' => $request->gender,
            'date_of_birth' => $request->date('date_of_birth'),
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'ref_id' => empty($request->invite) ? null : $request->invite,
            'password' => bcrypt($request->password),
            'status' => 1,
            'two_fa' => 0,
            'deposit_status' => 1,
            'withdraw_status' => 1,
            'transfer_status' => 4,
            'otp_status' => 0,
            'referral_status' => 1,
            'email_verified_at' => now(),
            'kyc' => KYCStatus::NOT_SUBMITTED,
            'user_type' => $request->user_type,
        ]);

        if ($request->kyc_credential) {
            $kycs = $request->kyc_credential;

            foreach ($kycs as $id => $kyc) {
                if (is_array($kyc)) {
                    foreach ($kyc as $key => $value) {
                        if (is_file($value)) {
                            $kycs[$id][$key] = self::imageUploadTrait($value);
                        }
                    }
                }
            }

            foreach ($request->kyc_ids as $id) {
                $kyc = Kyc::find($id);

                UserKyc::create([
                    'user_id' => $user->id,
                    'kyc_id' => $kyc->id,
                    'type' => $kyc->name,
                    'data' => $kycs[$id],
                    'is_valid' => true,
                    'status' => 'pending',
                ]);
            }
        }

        if (setting('referral_signup_bonus', 'permission') && (float) setting('signup_bonus', 'fee') > 0) {
            $signupBonus = (float) setting('signup_bonus', 'fee');
            $user->increment('balance', $signupBonus);
            (new Txn)->new($signupBonus, 0, $signupBonus, 'system', 'Signup Bonus', TxnType::SignupBonus, TxnStatus::Success, null, null, $user->id);
        }

        notify()->success(__('Customer added successfully!'), 'Success');

        return to_route('admin.user.edit', $user->id);

    }

    /**
     * @return RedirectResponse
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        User::find($id)->update($input);
        notify()->success(__('User Info Updated Successfully'), 'Success');

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function passwordUpdate($id, Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $password = $validator->validated();

        User::find($id)->update([
            'password' => Hash::make($password['new_password']),
        ]);
        notify()->success(__('User Password Updated Successfully'), 'Success');

        return redirect()->back();
    }

    /**
     * @return RedirectResponse|void
     */
    public function balanceUpdate($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'type' => 'required',
            'wallet' => 'nullable|in:balance,topup_balance',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        try {

            $amount = $request->amount;
            $type = $request->type;
            $wallet = $request->wallet;

            $user = User::find($id);
            $adminUser = Auth::user();

            if ($type == 'add') {

                $user->is_seller ? $user->balance += $amount : $user->{$request->wallet} += $amount;
                $user->save();

                (new Txn)->new($amount, 0, $amount, 'system', 'Money added in ' . ucwords($wallet) . ' Wallet from System', TxnType::Deposit, TxnStatus::Success, null, null, $id, $adminUser->id, 'Admin');

                $status = 'Success';
                $message = __('Balance added successfully!');

            } elseif ($type == 'subtract') {

                $user->is_seller ? $user->balance -= $amount : $user->topup_balance -= $amount;
                $user->save();

                (new Txn)->new($amount, 0, $amount, 'system', 'Money subtract in ' . ucwords($wallet) . ' Wallet from System', TxnType::Subtract, TxnStatus::Success, null, null, $id, $adminUser->id, 'Admin');
                $status = 'Success';
                $message = __('Balance subtracted successfully!');
            }

            notify()->success($message, $status);

            return redirect()->back();

        } catch (Exception $e) {
            $status = 'warning';
            $message = __('something is wrong');
            $code = 503;
        }

    }

    /**
     * @return Application|Factory|View
     */
    public function mailSendAll()
    {
        return view('backend.user.mail_send_all');
    }

    /**
     * @return RedirectResponse
     */
    public function mailSend(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
            'user_type' => 'required|in:all,buyer,seller',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        try {

            $input = [
                'subject' => $request->subject,
                'message' => $request->message,
            ];

            $shortcodes = [
                '[[subject]]' => $input['subject'],
                '[[message]]' => $input['message'],
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
            ];

            if (isset($request->id)) {
                $user = User::find($request->id);

                $shortcodes = array_merge($shortcodes, ['[[full_name]]' => $user->full_name]);

                $this->mailNotify($user->email, 'user_mail', $shortcodes);

            } else {
                $users = User::where('status', 1)
                    ->when($request->user_type != 'all', function ($query) use ($request) {
                        $query->where('user_type', $request->user_type);
                    })->get();

                foreach ($users as $user) {
                    $shortcodes = array_merge($shortcodes, ['[[full_name]]' => $user->full_name]);

                    $this->mailNotify($user->email, 'user_mail', $shortcodes);
                }

            }
            $status = 'Success';
            $message = __('Mail Send Successfully');

        } catch (Exception $e) {

            $status = 'warning';
            $message = __('Sorry, something is wrong');
        }

        notify()->$status($message, $status);

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function userLogin($id)
    {
        Auth::guard('web')->loginUsingId($id);

        try {
            \Log::alert("Admin Logged in to User: '" . Auth::guard('web')->user()->username . "' from Ip: " . request()->ip() . ' Country: ' . getLocation()?->name);
        } catch (\Throwable $th) {
            \Log::error("Error while logging admin login to user: " . $th->getMessage());
        }

        return redirect()->route('user.dashboard');
    }

    public function destroy($id)
    {

        try {

            $user = User::find($id);
            $user->kycs()->delete();
            $user->transaction()->delete();
            $user->ticket()->delete();
            $user->activities()->delete();
            $user->messages()->delete();
            $user->notifications()->delete();
            $user->refferelLinks()->delete();
            $user->withdrawAccounts()->delete();
            $user->withdraws()->delete();
            $user->planHistories()->delete();
            $user->listings()->delete();
            $user->coupons()->delete();
            $user->delete();

            notify()->success(__('User deleted successfully'), 'Success');

            return to_route('admin.user.' . $user->user_type . 's.all');

        } catch (\Throwable $th) {
            notify()->error(__('Sorry, something went wrong!'), 'Error');

            return redirect()->back();
        }

    }

    public function popularToggle($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_popular' => !$user->is_popular]);
        notify()->success(__('User popular status updated successfully!'));

        return back();
    }

    public function disabled(Request $request, $type = null)
    {
        $search = $request->query('query') ?? null;

        $users = User::disabled()
            ->when(!blank(request('email_status')), function ($query) {
                if (request('email_status')) {
                    $query->whereNotNull('email_verified_at');
                } else {
                    $query->whereNull('email_verified_at');
                }
            })
            ->when(!blank($type), function ($query) use ($type) {
                $query->where('user_type', $type);
            })
            ->when(!blank(request('kyc_status')), function ($query) {
                $query->where('kyc', request('kyc_status'));
            })
            ->where('status', '0')
            ->when(!blank(request('sort_field')), function ($query) {
                $query->orderBy(request('sort_field'), request('sort_dir'));
            })
            ->when(!request()->has('sort_field'), function ($query) {
                $query->latest();
            })
            ->search($search)
            ->paginate();

        $title = __('Disabled :type', ['type' => ucfirst($type)]);

        return view('backend.user.index', compact('users', 'title'));
    }

    public function __disabled(Request $request)
    {
        $userType = str(url()->current())->after('disabled/')->value();

        return $this->disabled($request, $userType);
    }

    public function __closed(Request $request)
    {
        $userType = str(url()->current())->after('closed/')->value();

        return $this->closed($request, $userType);
    }

    public function closed(Request $request, $type = null)
    {
        $search = $request->query('query') ?? null;

        $users = User::closed()
            ->when(!blank(request('email_status')), function ($query) {
                if (request('email_status')) {
                    $query->whereNotNull('email_verified_at');
                } else {
                    $query->whereNull('email_verified_at');
                }
            })
            ->when(!blank($type), function ($query) use ($type) {
                $query->where('user_type', $type);
            })
            ->when(!blank(request('kyc_status')), function ($query) {
                $query->where('kyc', request('kyc_status'));
            })
            ->where('status', '2')
            ->when(!blank(request('sort_field')), function ($query) {
                $query->orderBy(request('sort_field'), request('sort_dir'));
            })
            ->when(!request()->has('sort_field'), function ($query) {
                $query->latest();
            })
            ->search($search)
            ->paginate();
        $title = __('Closed ', ['type' => ucfirst($type)]);

        return view('backend.user.index', compact('users', 'title'));
    }
}
