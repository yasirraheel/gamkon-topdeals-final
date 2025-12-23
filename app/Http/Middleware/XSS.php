<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class XSS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $userInput = $request->all();
        array_walk_recursive($userInput, function (&$userInput) {
            $userInput = strip_tags($userInput) !== $userInput ? Purifier::clean($userInput) : $userInput;
        });
        $request->merge($userInput);

        // Set mail configuration from settings

        config()->set([
            // social logins
            'services.google.client_id' => setting('google_client_id', 'social_login'),
            'services.google.client_secret' => setting('google_secret_key', 'social_login'),
            'services.google.redirect' => isDevMode() ? 'http://localhost/gamkon/social/login/google/callback' : route('social.login.callback', ['provider' => 'google']),
            'services.facebook.client_id' => setting('facebook_client_id', 'social_login'),
            'services.facebook.client_secret' => setting('facebook_secret_key', 'social_login'),
            'services.facebook.redirect' => isDevMode() ? 'http://localhost/gamkon/social/login/facebook/callback' : route('social.login.callback', ['provider' => 'facebook']),
        ]);

        return $next($request);
    }
}
