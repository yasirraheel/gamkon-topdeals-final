<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Subscription;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function home()
    {

        $customLandingTheme = Theme::where('type', 'landing')->where('status', true)->first();
        if ($customLandingTheme) {
            return view('landing_theme.'.$customLandingTheme->name);
        }

        $redirectPage = setting('home_redirect', 'global');

        if ($redirectPage == '/') {
            $homeContent = getLandingPageData()->where('code', '!=', 'footer')->where('status', true)->orderBy('short')->get();
            if (setting('flash_sale_status', 'flash_sale')) {
                $flashSellListing = Listing::with('productCatalog')->public()->where('is_flash', true)->latest()->get();
            } else {
                $flashSellListing = [];
            }

            return view('frontend::home.index', compact('homeContent', 'flashSellListing'));
        }

        return redirect($redirectPage);

    }

    public function subscribeNow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:subscriptions'],
        ]);

        if ($validator->fails()) {
            Cookie::queue(Cookie::make('reject_signup_first_order_bonus', true, 60 * 24 * 365));
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        Subscription::create([
            'email' => $request->email,
        ]);
        Cookie::queue(Cookie::make('reject_signup_first_order_bonus', true, 60 * 24 * 365));

        notify()->success(__('Subscribed Successfully'));

        return redirect()->back();
    }

    public function themeMode()
    {

        $oldTheme = session()->get('site-color-mode', setting('default_mode'));

        if ($oldTheme == 'dark') {
            session()->put('site-color-mode', 'light');
        } else {
            session()->put('site-color-mode', 'dark');
        }
    }

    public function languageUpdate(Request $request)
    {
        session()->put('locale', $request->name);

        return redirect()->back();
    }

    public function session(Request $request)
    {
        $key = $request->input('key');

        $value = $request->input('value');

        session([$key => $value]);

        return response()->json(['success' => true]);
    }
}
