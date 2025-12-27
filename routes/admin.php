<?php

use App\Http\Controllers\Backend\AppController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\CronJobController;
use App\Http\Controllers\Backend\CustomCssController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DepositController;
use App\Http\Controllers\Backend\EmailTemplateController;
use App\Http\Controllers\Backend\GatewayController;
use App\Http\Controllers\Backend\KycController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\ListingController;
use App\Http\Controllers\Backend\NavigationController;
use App\Http\Controllers\Backend\NotificationController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\PluginController;
use App\Http\Controllers\Backend\ProductCatalogController;
use App\Http\Controllers\Backend\ReferralController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SellerRankingController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SmsController;
use App\Http\Controllers\Backend\SocialController;
use App\Http\Controllers\Backend\StaffController;
use App\Http\Controllers\Backend\SubscriptionPlanController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\ThemeController;
use App\Http\Controllers\Backend\TicketController;
use App\Http\Controllers\Backend\TransactionController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\UserNavigationController;
use App\Http\Controllers\Backend\WithdrawController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

// Admin Dashboard
Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

// ===============================  Customer Management ==================================
Route::resource('user', UserController::class)->only('index', 'edit', 'update');
Route::group(['prefix' => 'user', 'as' => 'user.', 'controller' => UserController::class], function () {
    Route::get('sellers', 'sellerUser')->name('sellers.all');
    Route::get('buyers', 'buyerUser')->name('buyers.all');
    Route::get('login/{id}', 'userLogin')->name('login');
    Route::get('add-new/seller', 'create')->name('sellers.new');
    Route::get('add-new/buyer', 'create')->name('buyers.new');
    Route::post('store', 'store')->name('store');
    Route::post('status-update/{id}', 'statusUpdate')->name('status-update');
    Route::post('password-update/{id}', 'passwordUpdate')->name('password-update');
    Route::post('balance-update/{id}', 'balanceUpdate')->name('balance-update');
    Route::delete('destroy/{id}', 'destroy')->name('destroy');
    Route::get('popular-toggle/{id}', 'popularToggle')->name('popular.toggle');

    Route::get('disabled/seller', '__disabled')->name('sellers.disabled');
    Route::get('disabled/buyer', '__disabled')->name('buyers.disabled');

    Route::get('closed/seller', '__closed')->name('sellers.closed');
    Route::get('closed/buyer', '__closed')->name('buyers.closed');

});

Route::resource('kyc-form', KycController::class);
Route::group(['prefix' => 'id-verification', 'as' => 'kyc.', 'controller' => KycController::class], function () {
    Route::get('pending', 'KycPending')->name('pending');
    Route::get('rejected', 'KycRejected')->name('rejected');
    Route::get('action/{id}', 'depositAction')->name('action');
    Route::post('action-now', 'actionNow')->name('action.now');
    Route::get('all', 'kycAll')->name('all');
});

// ===============================  Role Management ==================================
Route::resource('roles', RoleController::class)->except('show', 'destroy');
Route::resource('staff', StaffController::class)->except('show', 'destroy', 'create');

// ===============================  Transactions ==================================
Route::get('transactions', [TransactionController::class, 'transactions'])->name('transactions');
// ===============================  Subscription Plan ==================================

Route::controller(SubscriptionPlanController::class)->name('subscription.plan.')->prefix('pricing-plans')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::post('/delete/{id}', 'delete')->name('delete');
});

// ===============================  Essentials ==================================

Route::group(['prefix' => 'gateway', 'as' => 'gateway.', 'controller' => GatewayController::class], function () {
    Route::get('/automatic', 'automatic')->name('automatic');
    Route::post('update/{id}', 'update')->name('update')->withoutMiddleware('XSS');
    Route::get('currency/{gateway_id}', 'gatewayCurrency')->name('supported.currency');
});

// ===============================  Order ==================================
Route::prefix('order')->name('order.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::post('/{order}/update-status', [OrderController::class, 'updateStatus'])->name('update-status');

});

// =============================== Category Management ===============================

Route::controller(CategoryController::class)->name('category.')->prefix('categories')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::get('/trending-toggle/{id}', 'trendingToggle')->name('trending.toggle');
    Route::post('/delete/{id}', 'destroy')->name('delete');
});

// =============================== Product Catalog Management ===============================

Route::controller(ProductCatalogController::class)->name('product-catalog.')->prefix('product-catalog')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::get('/status-toggle/{id}', 'statusToggle')->name('status.toggle');
    Route::post('/delete/{id}', 'destroy')->name('delete');
});

// =============================== Listing Management ===============================
Route::prefix('listing')->name('listing.')->group(function () {
    Route::post('delete/{id}', [ListingController::class, 'destroy'])->name('delete');
    Route::get('approval-toggle/{id}', [ListingController::class, 'approvalToggle'])->name('approval.toggle');
    Route::get('/trending-toggle/{id}', [ListingController::class, 'trendingToggle'])->name('trending.toggle');
    Route::post('/status-update/{id}', [ListingController::class, 'statusUpdate'])->name('status.update');
    Route::get('/details/{id}', [ListingController::class, 'listingDetails'])->name('view');
    Route::get('/{status?}', [ListingController::class, 'index'])->name('index');

});

// Review Management Routes
Route::prefix('reviews')->name('reviews.')->group(function () {
    Route::get('/create', [ReviewController::class, 'create'])->name('create');
    Route::post('/store', [ReviewController::class, 'store'])->name('store');
    Route::get('', [ReviewController::class, 'index'])->name('index');
    Route::get('/recalculate', [ReviewController::class, 'recalculate'])->name('recalculate');
    Route::get('/{review}', [ReviewController::class, 'show'])->name('show');
    Route::get('/{review}/approve', [ReviewController::class, 'approve'])->name('approve');
    Route::patch('/{review}/reject', [ReviewController::class, 'reject'])->name('reject');
    Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('delete');

});

// User navigations
Route::group(['prefix' => 'navigations', 'as' => 'user.navigation.', 'controller' => UserNavigationController::class], function () {
    Route::get('/{visible_for}', 'index')->name('index');
    Route::get('edit/{id}', 'edit')->name('edit');
    Route::post('update/{id}', 'update')->name('update');
    Route::post('position-update', 'positionUpdate')->name('position.update');
});

// =============================== Coupon Management ===============================
Route::name('coupon.')->prefix('coupon')->group(function () {
    Route::get('create', [CouponController::class, 'create'])->name('create');
    Route::post('store', [CouponController::class, 'store'])->name('store');
    Route::get('{id}/edit', [CouponController::class, 'edit'])->name('edit');
    Route::post('{id}/update', [CouponController::class, 'update'])->name('update');
    Route::post('{id}/delete', [CouponController::class, 'destroy'])->name('delete');
    Route::get('/{status?}', [CouponController::class, 'index'])->name('index');
});

Route::group(['prefix' => 'deposit', 'as' => 'deposit.', 'controller' => DepositController::class], function () {
    // =============================== deposit Method ================================
    Route::group(['prefix' => 'method', 'as' => 'method.'], function () {
        Route::get('list/{type}', 'methodList')->name('list');
        Route::get('create/{type}', 'createMethod')->name('create');
        Route::post('store', 'methodStore')->name('store')->withoutMiddleware('XSS');
        Route::get('edit/{type}', 'methodEdit')->name('edit');
        Route::post('update/{id}', 'methodUpdate')->name('update')->withoutMiddleware('XSS');
    });
    // =============================== end deposit Method ================================

    Route::get('manual-pending', 'pending')->name('manual.pending');
    Route::get('history', 'history')->name('history');
    Route::get('action/{id}', 'depositAction')->name('action');
    Route::post('action-now', 'actionNow')->name('action.now');
});

Route::group(['prefix' => 'payout', 'as' => 'withdraw.', 'controller' => WithdrawController::class], function () {
    // =============================== withdraw Method ================================
    Route::group(['prefix' => 'method', 'as' => 'method.'], function () {
        Route::get('list/{type}', 'methods')->name('list');
        Route::get('create/{type}', 'methodCreate')->name('create');
        Route::post('store', 'methodStore')->name('store')->withoutMiddleware('XSS');
        Route::get('edit/{type}', 'methodEdit')->name('edit');
        Route::post('update/{id}', 'methodUpdate')->name('update')->withoutMiddleware('XSS');
    });

    // Schedule
    Route::get('schedule', 'schedule')->name('schedule');
    Route::post('schedule-update', 'scheduleUpdate')->name('schedule.update');

    Route::get('history', 'history')->name('history');
    Route::get('pending', 'pending')->name('pending');

    Route::get('action/{id}', 'withdrawAction')->name('action');
    Route::post('action-now', 'actionNow')->name('action.now');
});

Route::group(['prefix' => 'referral', 'as' => 'referral.', 'controller' => ReferralController::class], function () {
    Route::get('settings', 'settings')->name('settings');
    Route::get('index', 'index')->name('index');
    Route::post('store', 'store')->name('store');
    Route::post('update/{id}', 'update')->name('update');
    Route::post('delete/{id}', 'destroy')->name('delete');
    Route::post('level-status', 'statusUpdate')->name('status');
});

// ===============================  Site Essentials ==================================

Route::group(['prefix' => 'theme', 'as' => 'theme.', 'controller' => ThemeController::class], function () {

    Route::get('site', 'siteTheme')->name('site');
    Route::get('dynamic-landing', 'dynamicLanding')->name('dynamic-landing');

    Route::get('status-update', 'statusUpdate')->name('status-update');

    Route::post('dynamic-landing-update', 'dynamicLandingUpdate')->name('dynamic-landing-update');
    Route::get('dynamic-landing-status-update', 'dynamicLandingStatusUpdate')->name('dynamic-landing-status-update');
    Route::post('dynamic-landing-delete/{id}', 'dynamicLandingDelete')->name('dynamic-landing-delete');
});

Route::group(['prefix' => 'navigation', 'as' => 'navigation.', 'controller' => NavigationController::class], function () {
    Route::get('menu', 'index')->name('menu');
    Route::post('menu-add', 'store')->name('menu.add');
    Route::get('menu-edit/{id}', 'edit')->name('menu.edit');
    Route::post('menu-update', 'update')->name('menu.update');
    Route::post('menu-delete', 'delete')->name('menu.delete');
    Route::get('menu-delete/{id}/{type}', 'typeDelete')->name('menu.type.delete');
    Route::post('menu-position-update', 'positionUpdate')->name('position.update');

    Route::get('header', 'header')->name('header');
    Route::get('footer', 'footer')->name('footer');

    Route::get('translate/{id}', 'translate')->name('translate');
    Route::post('translate', 'translateNow')->name('translate.now');
});

Route::group(['prefix' => 'page', 'as' => 'page.', 'controller' => PageController::class], function () {
    Route::get('create', 'create')->name('create');
    Route::post('store', 'store')->name('store')->withoutMiddleware('XSS');
    Route::get('edit/{name}', 'edit')->name('edit');
    Route::post('update', 'update')->name('update')->withoutMiddleware('XSS');
    Route::post('delete/now', 'deleteNow')->name('delete.now');

    Route::get('section/{section}', 'landingSection')->name('section.section');
    Route::post('section/update', 'landingSectionUpdate')->name('section.section.update');
    Route::post('content-store', 'contentStore')->name('content-store');
    Route::get('content-edit/{id}', 'contentEdit')->name('content-edit');
    Route::post('content-update', 'contentUpdate')->name('content-update');
    Route::post('content-delete', 'contentDelete')->name('content-delete');
    Route::get('landing-section-management', 'management')->name('section.management');
    Route::post('landing-section-update', 'managementUpdate')->name('section.management.update');

    Route::resource('blog', BlogController::class)->except('show')->withoutMiddleware('XSS');

    Route::group(['prefix' => 'testimonial', 'as' => 'testimonial.', 'controller' => TestimonialController::class], function () {
        Route::post('store', 'store')->name('store');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('delete', 'destroy')->name('delete');
    });

    Route::get('settings', 'pageSetting')->name('setting');
    Route::post('setting-update', 'pageSettingUpdate')->name('setting.update');
});
Route::get('footer-content', [PageController::class, 'footerContent'])->name('footer-content');

Route::group(['prefix' => 'social', 'as' => 'social.', 'controller' => SocialController::class], function () {
    Route::post('store', 'store')->name('store');
    Route::post('update', 'update')->name('update');
    Route::post('delete', 'delete')->name('delete');
    Route::post('position-update', 'positionUpdate')->name('position.update');
});

// ===============================  site Settings ==================================
Route::group(['prefix' => 'settings', 'as' => 'settings.', 'controller' => SettingController::class], function () {
    Route::get('site', 'siteSetting')->name('site');
    Route::get('seo-meta', 'seoMeta')->name('seo.meta');
    Route::get('mail', 'mailSetting')->name('mail');
    Route::post('mail-connection-test', 'mailConnectionTest')->name('mail.connection.test');
    Route::post('update', 'update')->name('update');

    Route::get('plugin/{name}', [PluginController::class, 'plugin'])->name('plugin');
    Route::get('plugin-data/{id}', [PluginController::class, 'pluginData'])->name('plugin.data');
    Route::post('plugin-update/{id}', [PluginController::class, 'update'])->name('plugin.update');

    // notification tune
    Route::group(['prefix' => 'notification', 'as' => 'notification.', 'controller' => NotificationController::class], function () {
        Route::get('tune', 'setTune')->name('tune');
        Route::get('tune/status/{id}', 'status')->name('tune.status');
    });

});

// ===============================  Ad Management ==================================
Route::post('ad-units/settings', [\App\Http\Controllers\Backend\AdUnitController::class, 'updateSettings'])->name('ad-units.settings.update');
Route::resource('ad-units', \App\Http\Controllers\Backend\AdUnitController::class);
Route::get('ad-units/status/{id}', [\App\Http\Controllers\Backend\AdUnitController::class, 'statusUpdate'])->name('ad-units.status');

// Portfolio
Route::resource('seller-ranking', SellerRankingController::class)->only('index', 'store', 'update')->parameter('seller-ranking', 'portfolio');

// show all notifications
Route::get('notification/all', [NotificationController::class, 'all'])->name('notification.all');
Route::get('latest-notification', [NotificationController::class, 'latestNotification'])->name('latest-notification');
Route::get('notification-read/{id}', [NotificationController::class, 'readNotification'])->name('read-notification');

Route::resource('language', LanguageController::class);
Route::get('language-keyword/{language}', [LanguageController::class, 'languageKeyword'])->name('language-keyword');
Route::post('language-keyword-update', [LanguageController::class, 'keywordUpdate'])->name('language-keyword-update');
Route::get('language-sync-missing', [LanguageController::class, 'syncMissing'])->name('language-sync-missing');

Route::get('email-template', [EmailTemplateController::class, 'index'])->name('email-template');
Route::get('email-template-edit/{id}', [EmailTemplateController::class, 'edit'])->name('email-template-edit');
Route::post('email-template-update', [EmailTemplateController::class, 'update'])->name('email-template-update');

Route::group(['prefix' => 'template', 'as' => 'template.'], function () {
    Route::group(['prefix' => 'sms', 'as' => 'sms.', 'controller' => SmsController::class], function () {
        Route::get('/', 'template')->name('index');
        Route::get('template-edit/{id}', 'edit_template')->name('template-edit');
        Route::post('template-update', 'update_template')->name('template-update');
    });

    Route::group(['prefix' => 'notification', 'as' => 'notification.', 'controller' => NotificationController::class], function () {
        Route::get('/', 'template')->name('index');
        Route::get('template-edit/{id}', 'editTemplate')->name('template-edit');
        Route::post('template-update', 'updateTemplate')->name('template-update');
    });
});

// ===============================  Others ==================================
Route::group(['controller' => AppController::class], function () {
    Route::get('subscribers', 'subscribers')->name('subscriber');
    Route::get('mail-send-subscriber', 'mailSendSubscriber')->name('mail.send.subscriber');
    Route::post('mail-send-subscriber-now', 'mailSendSubscriberNow')->name('mail.send.subscriber.now');
});
// Admin Mail Send

Route::controller(UserController::class)->prefix('mail-send')->as('mail-send.')->group(function () {
    Route::get('all', 'mailSendAll')->name('all');
    Route::post('', 'mailSend')->name('sent');
});

Route::group(['prefix' => 'support-ticket', 'as' => 'ticket.', 'controller' => TicketController::class], function () {
    Route::get('index/{id?}', 'index')->name('index');
    Route::post('reply', 'reply')->name('reply');
    Route::get('show/{uuid}', 'show')->name('show');
    Route::get('close-now/{uuid}', 'closeNow')->name('close.now');
});

Route::controller(CronJobController::class)->as('cron.jobs.')->prefix('cron-jobs')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('store', 'store')->name('store');
    Route::post('update/{id}', 'update')->name('update');
    Route::post('delete/{id}', 'delete')->name('delete');
    Route::get('run-now/{id}', 'runNow')->name('run.now');
    Route::get('logs/{id}', 'logs')->name('logs');
    Route::get('clear-logs/{id}', 'clearLogs')->name('clear.logs');
});

Route::get('custom-css', [CustomCssController::class, 'customCss'])->name('custom-css');
Route::post('custom-css-update', [CustomCssController::class, 'customCssUpdate'])->name('custom-css.update');

Route::get('profile', [AppController::class, 'profile'])->name('profile');
Route::post('profile-update', [AppController::class, 'profileUpdate'])->name('profile-update');

Route::get('password-change', [AppController::class, 'passwordChange'])->name('password-change');
Route::post('password-update', [AppController::class, 'passwordUpdate'])->name('password-update');

Route::get('application-info', [AppController::class, 'applicationInfo'])->name('application-info');
Route::get('clear-cache', [AppController::class, 'clearCache'])->name('clear-cache');

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->withoutMiddleware('isDemo');
