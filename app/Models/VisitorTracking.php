<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VisitorTracking extends Model
{
    protected $table = 'visitor_tracking';
    protected $guarded = ['id'];

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for date filtering
     */
    public function scopeWithinDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Get country statistics (top countries by visitor count)
     *
     * @param int $limit Number of countries to return
     * @return array Array with country names as keys and counts as values
     */
    public static function getCountryStats($limit = 5)
    {
        return static::select('country', DB::raw('count(*) as count'))
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit($limit)
            ->pluck('count', 'country')
            ->toArray();
    }

    /**
     * Get unique visitor count by IP
     *
     * @param string|null $startDate Start date for filtering
     * @param string|null $endDate End date for filtering
     * @return int Unique visitor count
     */
    public static function getUniqueVisitorCount($startDate = null, $endDate = null)
    {
        $query = static::select(DB::raw('COUNT(DISTINCT ip) as unique_visitors'));

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query->value('unique_visitors') ?? 0;
    }
}
