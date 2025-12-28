<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class IpGeolocation extends Model
{
    protected $table = 'ip_geolocation_cache';
    protected $guarded = ['id'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Check if cache is still valid
     *
     * @return bool
     */
    public function isValid()
    {
        if ($this->expires_at === null) {
            return true; // Never expires
        }

        return $this->expires_at->isFuture();
    }

    /**
     * Get geolocation from cache or fetch from API
     *
     * @param string $ip IP address to lookup
     * @return array Geolocation data
     */
    public static function getOrFetch($ip)
    {
        // Check cache first
        $cached = static::where('ip', $ip)->first();

        if ($cached && $cached->isValid()) {
            return [
                'country' => $cached->country,
                'country_code' => $cached->country_code,
                'ip' => $cached->ip,
            ];
        }

        // Fetch from API
        $location = static::fetchFromApi($ip);

        // Store in cache
        static::updateOrCreate(
            ['ip' => $ip],
            [
                'country' => $location['country'] ?? null,
                'country_code' => $location['country_code'] ?? null,
                'region' => $location['region'] ?? null,
                'city' => $location['city'] ?? null,
                'latitude' => $location['latitude'] ?? null,
                'longitude' => $location['longitude'] ?? null,
                'expires_at' => Carbon::now()->addDays(30), // Cache for 30 days
            ]
        );

        return $location;
    }

    /**
     * Fetch geolocation from ip-api.com
     *
     * @param string $ip IP address to lookup
     * @return array Geolocation data
     */
    protected static function fetchFromApi($ip)
    {
        // Use fallback IP for localhost
        $clientIp = $ip == '127.0.0.1' ? '103.77.188.202' : $ip;

        try {
            $response = json_decode(
                curl_get_file_contents('http://ip-api.com/json/' . $clientIp),
                true
            );

            if (!$response || ($response['status'] ?? '') == 'fail') {
                return [
                    'country' => 'Unknown',
                    'country_code' => 'XX',
                    'ip' => $ip,
                ];
            }

            return [
                'country' => $response['country'] ?? 'Unknown',
                'country_code' => $response['countryCode'] ?? 'XX',
                'region' => $response['regionName'] ?? null,
                'city' => $response['city'] ?? null,
                'latitude' => $response['lat'] ?? null,
                'longitude' => $response['lon'] ?? null,
                'ip' => $ip,
            ];
        } catch (\Exception $e) {
            \Log::error('IP geolocation API failed: ' . $e->getMessage());

            return [
                'country' => 'Unknown',
                'country_code' => 'XX',
                'ip' => $ip,
            ];
        }
    }
}
