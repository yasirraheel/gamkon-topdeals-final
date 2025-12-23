<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserPermissionChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $settingPermission = null, ?string $userWisePermissions = null): Response
    {
        $user = auth()->user();
        $settingPermission = str($settingPermission)->before(',')->replace(['user_type'], [$user->user_type])->value();
        $userWisePermissions = str($userWisePermissions)->after(',')->replace(['user_type'], [$user->user_type])->value();

        if ($settingPermission && ! setting($settingPermission, 'permission')) {
            notify()->error(__('You do not have permission to access this page.'), str($settingPermission)->headline().' Permission');

            return back();
        }
        if ($userWisePermissions && ! empty($userWisePermissions) && ! $user->{$userWisePermissions}) {
            notify()->error(__('You do not have permission to access this page.'), str($userWisePermissions)->headline().' Permission');

            return back();
        }

        return $next($request);
    }
}
