<?php

namespace App\Http\Controllers;

use App\Enums\ListingStatus;
use App\Enums\PlanHistoryStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Models\Category;
use App\Models\CronJob;
use App\Models\CronJobLog;
use App\Models\Listing;
use App\Models\Order;
use App\Models\PlanHistory;
use App\Models\Portfolio;
use App\Models\User;
use App\Traits\NotifyTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Remotelywork\Installer\Repository\App;

class CronJobController extends Controller
{
    use NotifyTrait;

    public function runCronJobs()
    {

        $action_id = request('run_action');

        if (is_null($action_id)) {
            $jobs = CronJob::where('status', 'running')
                ->where('next_run_at', '<', now())
                ->get();
        } else {
            $jobs = CronJob::whereKey($action_id)->get();
        }

        foreach ($jobs as $job) {

            $error = null;

            $log = new CronJobLog;
            $log->cron_job_id = $job->id;
            $log->started_at = now();

            try {

                if ($job->type == 'system') {
                    $this->{$job->reserved_method}();
                } else {
                    Http::withOptions([
                        'verify' => false,
                    ])->get($job->url);
                }
            } catch (\Throwable $th) {
                $error = $th->getMessage();
            }

            $log->ended_at = now();
            $log->error = $error;
            $log->save();

            $job->update([
                'last_run_at' => now(),
                'next_run_at' => now()->addSeconds($job->schedule),
            ]);
        }

        if ($action_id !== null) {
            notify()->success(__('Cron running successfully!'), 'Success');

            return back();
        }
    }

    public function planSubscription()
    {

        $expiredPlans = PlanHistory::with('plan')->where('status', PlanHistoryStatus::ACTIVE)->where('validity_at', '<=', now())->get();

        try {
            DB::beginTransaction();

            foreach ($expiredPlans as $expiredPlan) {

                $shortcodes = [
                    '[[plan_name]]' => $expiredPlan->plan?->name,
                    '[[expired_at]]' => $expiredPlan->validity_at,
                    '[[full_name]]' => $expiredPlan->plan?->user?->full_name,
                    '[[site_title]]' => setting('site_title', 'global'),
                ];
                $expiredPlan->update([
                    'status' => PlanHistoryStatus::EXPIRED,
                ]);

                $plan = $expiredPlan->plan;

                Listing::where('seller_id', $expiredPlan->user_id)->where('status', ListingStatus::Active)
                    ->update(['status' => ListingStatus::PlanExpired, 'is_flash' => 0]);

                $this->pushNotify('plan_expired', $shortcodes, url('plans'), $plan->user_id);
                $this->mailNotify($expiredPlan->user?->email, 'plan_expired', $shortcodes);
            }

            DB::commit();

            return '........expired users plan successfully.';
        } catch (\Throwable $th) {
            DB::rollBack();

            return $th->getMessage();
        }
    }

    public function userInactive()
    {
        if (! setting('inactive_account_disabled', 'inactive_user') == 1) {
            return false;
        }

        try {

            DB::beginTransaction();
            $this->startCron();

            User::whereDoesntHave('activities', function ($query) {
                $query->where('created_at', '>', now()->subDays(30));
            })->where('status', 1)->chunk(500, function ($inactiveUsers) {
                foreach ($inactiveUsers as $user) {
                    $user->update(['status' => 0]);
                    $shortcodes = [
                        '[[full_name]]' => $user->full_name,
                        '[[site_title]]' => setting('site_title', 'global'),
                        '[[site_url]]' => route('home'),
                        '[[inactive_days]]' => setting('inactive_days', 'inactive_user'),
                    ];
                    $this->mailNotify($user->email, 'user_account_disabled', $shortcodes);
                }
            });

            DB::commit();

            return '........Inactive users disabled successfully.';
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function userPortfolio()
    {

        try {

            DB::beginTransaction();
            $this->startCron();

            $portfolios = Portfolio::where('status', true)->oldest('minimum_transactions')->get();

            User::where('status', true)->where('user_type', 'seller')->chunk(500, function ($users) use ($portfolios) {
                foreach ($users as $user) {

                    $eligiblePortfolios = $portfolios->reject(function ($rank) use ($user) {

                        $totalTransactions = $user->transaction->where('status', TxnStatus::Success)->whereNotIn('type', [TxnType::Subtract, TxnType::Refund, TxnType::PortfolioBonus])->sum('amount');

                        return is_array(json_decode($user->portfolios)) &&
                            in_array($rank->id, json_decode($user->portfolios)) ||
                            $rank->minimum_transactions > $totalTransactions;
                    });

                    if ($eligiblePortfolios !== null) {

                        $maxPortfolioTransctionsAmount = $eligiblePortfolios->max('minimum_transactions');

                        $highestPortfolio = $eligiblePortfolios->where('minimum_transactions', $maxPortfolioTransctionsAmount)->first();

                        $nonePortfolio = $eligiblePortfolios->where('minimum_transactions', 0)->first();

                        $userPortfolios = $user->portfolios != null ? json_decode($user->portfolios) : [];

                        foreach ($eligiblePortfolios as $portfolio) {

                            $userPortfolios = array_merge($userPortfolios, [$portfolio->id]);

                            if ($portfolio->bonus > 0) {
                                $user->balance += $portfolio->bonus;
                                $user->save();
                                (new Txn)->new($portfolio->bonus, 0, $portfolio->bonus, 'System', "'".$portfolio->portfolio_name."' Portfolio Bonus", TxnType::PortfolioBonus, TxnStatus::Success, null, null, $user->id);
                            }

                            $shortcodes = [
                                '[[portfolio_name]]' => $portfolio->portfolio_name,
                                '[[full_name]]' => $user->full_name,
                            ];

                            if ($portfolio->id === $highestPortfolio->id) {

                                if ($nonePortfolio != null && ! in_array($nonePortfolio->id, $userPortfolios)) {
                                    $userPortfolios = array_merge($userPortfolios, [$nonePortfolio->id]);
                                }
                                $user->update([
                                    'portfolio_id' => $portfolio->id,
                                    'portfolios' => json_encode($userPortfolios),
                                ]);

                                $this->mailNotify($user->email, 'portfolio_achieve', $shortcodes);
                                $this->pushNotify('portfolio_achieve', $shortcodes, route('user.setting.show'), $user->id);
                            }
                        }
                    }
                }
            });

            DB::commit();

            return '......User portfolio job completed successfully!';

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    protected function startCron()
    {
        if (! App::initApp()) {
            return false;
        }
    }

    public function trendingAndPopularSet()
    {
        try {
            DB::beginTransaction();
            $this->startCron();

            Listing::public()->update(['is_trending' => false]);

            Category::query()->update(['is_trending' => false]);

            User::query()->update(['is_popular' => false]);

            $lastWeek = now()->subWeek();

            $lastWeekOrders = Order::whereDate('created_at', '>=', $lastWeek);

            $lastWeekTrendingListings = (clone $lastWeekOrders)->groupBy('listing_id')->selectRaw('listing_id, count(*) as count')->orderBy('count', 'desc')->take(10)->pluck('listing_id', 'count');

            $lastWeekTrendingCategories = (clone $lastWeekOrders)->groupBy('category_id')->selectRaw('category_id, count(*) as count')->orderBy('count', 'desc')->take(10)->pluck('category_id', 'count');

            $lastWeekTrendingUsers = (clone $lastWeekOrders)->groupBy('seller_id')->selectRaw('seller_id, count(*) as count')->orderBy('count', 'desc')->take(10)->pluck('seller_id', 'count');

            Listing::whereIn('id', $lastWeekTrendingListings->values()->toArray())->update(['is_trending' => true]);

            Category::whereIn('id', $lastWeekTrendingCategories->values()->toArray())->update(['is_trending' => true]);

            User::where('user_type', 'seller')->whereIn('id', $lastWeekTrendingUsers->values()->toArray())->update(['is_popular' => true]);
            DB::commit();

            return '......Trending and popular listings, categories and users set successfully!';
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
