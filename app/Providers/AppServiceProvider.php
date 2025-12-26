<?php

namespace App\Providers;

use App\Facades\Notification\Notify;
use App\Facades\Txn\Txn;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Remotelywork\Installer\Repository\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application modules.
     *
     * @return void
     */
    public function register()
    {
        Paginator::defaultView('frontend::include.__pagination');
        
        // Override DotenvEditor with SafeDotenvEditor to prevent .env modification
        $this->app->bind('dotenv-editor', function ($app) {
            return new \App\Services\SafeDotenvEditor($app, $app['config']);
        });

        // URL::forceScheme('https');
        // if (!$this->app['request']->secure()) {
        //     return redirect()->to(url()->secure($this->app['request']->getRequestUri()));
        // }
    }

    /**
     * Bootstrap any application modules.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function boot()
    {
        if (!$this->app['request']->secure()) {
            return redirect()->to(url()->secure($this->app['request']->getRequestUri()));

        }

        $this->app->bind('notify', function () {
            return new Notify;
        });

        $this->app->bind('txn', function () {
            return new Txn;
        });

        if (App::dbConnectionCheck()) {
            $timezone = setting('site_timezone', 'global');

            config()->set([
                'app.timezone' => $timezone,
                'app.debug' => setting('debug_mode', 'permission'),
                'debugbar.enabled' => setting('debug_mode', 'permission'),
                'session.lifetime' => setting('session_lifetime', 'system'),
                'session.same_site' => env('APP_DEMO') ? 'none' : 'lax',
            ]);

            date_default_timezone_set($timezone);
        }

        Blade::directive('removeimg', function ($expression) {
            [$isHidden, $img_field] = explode(',', $expression);
            $isHidden = trim($isHidden);
            $img_field = trim($img_field);

            return "<?php \$isHidden = $isHidden; \$img_field = '$img_field'; ?>
            <div data-des=\"<?php echo \$img_field; ?>\" <?php if(!\$isHidden) echo 'hidden'; ?> class=\"close remove-img <?php echo \$img_field; ?>\"><i data-lucide=\"x\"></i></div>";
        });

        // Set string length to 255
        Schema::defaultStringLength(255);
    }
}
