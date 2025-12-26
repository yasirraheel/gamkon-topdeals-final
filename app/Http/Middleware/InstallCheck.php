<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InstallCheck
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('install') || $request->is('install/*')) {
            return $next($request);
        }

        // Example: Check if installed flag exists
        if (!file_exists(storage_path('installed'))) {
            return redirect('/install');
        }

        return $next($request);
    }
}
