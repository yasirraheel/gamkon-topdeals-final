<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {

        if (! setting('email_verification', 'permission')) {
            return redirect()->route('user.dashboard');
        }

        try {
            // code...
        } catch (\Throwable $th) {
            // throw $th;
        }

        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(RouteServiceProvider::HOME)
            : view('frontend::auth.verify-email');
    }
}
