<?php

namespace App\Http\Middleware;

use App\Models\IpGeolocation;
use App\Models\VisitorTracking;
use Closure;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Execute request first, then track on response
        $response = $next($request);

        // Only track successful GET requests (200 responses)
        if (!$this->shouldTrack($request, $response)) {
            return $response;
        }

        try {
            $this->trackVisit($request);
        } catch (\Exception $e) {
            // Silently fail - don't break user experience
            \Log::error('Visitor tracking failed: ' . $e->getMessage());
        }

        return $response;
    }

    /**
     * Determine if request should be tracked
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $response
     * @return bool
     */
    protected function shouldTrack(Request $request, $response): bool
    {
        // Only track GET requests (not POST/PUT/DELETE)
        if (!$request->isMethod('GET')) {
            return false;
        }

        // Only track successful responses
        if ($response->getStatusCode() !== 200) {
            return false;
        }

        // Exclude AJAX requests
        if ($request->ajax()) {
            return false;
        }

        // Exclude API routes
        if ($request->is('api/*')) {
            return false;
        }

        // Exclude admin panel routes
        $adminPrefix = setting('site_admin_prefix', 'global') ?? 'admin';
        if ($request->is($adminPrefix . '/*') || $request->is($adminPrefix)) {
            return false;
        }

        // Exclude specific routes
        if ($request->is('ipn/*') || $request->is('status/*')) {
            return false;
        }

        // Detect and exclude bots
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        if ($agent->isRobot()) {
            return false;
        }

        return true;
    }

    /**
     * Track the visit
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function trackVisit(Request $request): void
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        $ip = $request->ip();

        // Get geolocation (from cache or API)
        $location = IpGeolocation::getOrFetch($ip);

        // Create tracking record
        VisitorTracking::create([
            'ip' => $ip,
            'country' => $location['country'] ?? null,
            'country_code' => $location['country_code'] ?? null,
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'user_id' => auth()->check() ? auth()->id() : null,
        ]);
    }
}
