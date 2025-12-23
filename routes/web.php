<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\GatewayController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\IpnController;
use App\Http\Controllers\Frontend\ListingController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\StatusController;
use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::post('subscriber', [HomeController::class, 'subscribeNow'])->name('subscriber');

// Dynamic Page
Route::get('page/{section}', [PageController::class, 'getPage'])->name('dynamic.page');

Route::get('blog/{slug:blog}', [PageController::class, 'blogDetails'])->name('blog-details');
Route::post('mail-send', [PageController::class, 'mailSend'])->name('mail-send');

// public details page
Route::get('details/{slug}', [ListingController::class, 'listingDetails'])->name('listing.details')->where('slug', '[\w\d\-]+');
Route::post('seller-reply', [FrontendController::class, 'sellerReply'])->middleware(['auth', 'XSS'])->name('listing.seller.reply');
Route::post('review/flag', [FrontendController::class, 'sellerFlag'])->middleware(['auth', 'XSS'])->name('review.flag');

// seller
Route::get('all-sellers', [FrontendController::class, 'allSellers'])->name('all.sellers');
Route::get('seller/{user:username}', [FrontendController::class, 'sellerDetails'])->name('seller.details')->where('slug', '[\w\d\-]+');
Route::get('category/{category:slug?}', [FrontendController::class, 'getAllCategoryListing'])->name('category.listing');

// items
Route::get('all-items', [FrontendController::class, 'getAllCategoryListing'])->name('all.listing');
Route::get('categories', [FrontendController::class, 'getAllCategory'])->name('categories');
Route::get('search', [FrontendController::class, 'searchListing'])->name('search.listing');
Route::get('remove-recent-search', [FrontendController::class, 'removeRecentSearch'])->name('remove.recent.search');

// cookies
Route::get('cookies-accept', [FrontendController::class, 'acceptCookies'])->name('cookies.gdpr.accept');
Route::get('subscribed-signup-first-order-bonus-reject', [FrontendController::class, 'rejectSignupFirstOrderBonus'])->name('cookies.signup.first.order.bonus.reject');


Route::post('follow/{user:username}', [FrontendController::class, 'followSeller'])->name('follow.seller');
Route::post('buy-now', [CheckoutController::class, 'buyNow'])->name('buy-now');
Route::get('checkout/{type?}/{data?}', [CheckoutController::class, 'checkout'])->middleware(['auth'])->name('checkout');

// Translate
Route::get('language-update', [HomeController::class, 'languageUpdate'])->name('language-update');

// Gateway Manage
Route::get('gateway-list', [GatewayController::class, 'gatewayList'])->name('gateway.list')->middleware('XSS', 'translate', 'auth');

// Wishlist
Route::get('wishlist/add', [WishlistController::class, 'addToWishlist'])->name('addToWishlist');

// Payment

Route::post('payment', [CheckoutController::class, 'payment'])->name('payment');
// Gateway status
Route::group(['controller' => StatusController::class, 'prefix' => 'status', 'as' => 'status.'], function () {
    Route::match(['get', 'post'], '/success', 'success')->name('success');
    Route::match(['get', 'post'], '/cancel', 'cancel')->name('cancel');
    Route::match(['get', 'post'], '/pending', 'pending')->name('pending');
});

// Instant payment notification
Route::group(['prefix' => 'ipn', 'as' => 'ipn.', 'controller' => IpnController::class], function () {
    Route::post('coinpayments', 'coinpaymentsIpn')->name('coinpayments');
    Route::post('nowpayments', 'nowpaymentsIpn')->name('nowpayments');
    Route::post('cryptomus', 'cryptomusIpn')->name('cryptomus');
    Route::get('paypal', 'paypalIpn')->name('paypal');
    Route::post('mollie', 'mollieIpn')->name('mollie');
    Route::any('perfectmoney', 'perfectMoneyIpn')->name('perfectMoney');
    Route::get('paystack', 'paystackIpn')->name('paystack');
    Route::get('flutterwave', 'flutterwaveIpn')->name('flutterwave');
    Route::post('coingate', 'coingateIpn')->name('coingate');
    Route::get('monnify', 'monnifyIpn')->name('monnify');
    Route::get('non-hosted-securionpay', 'nonHostedSecurionpayIpn')->name('non-hosted.securionpay')->middleware(['auth', 'XSS']);
    Route::post('coinremitter', 'coinremitterIpn')->name('coinremitter');
    Route::post('btcpay', 'btcpayIpn')->name('btcpay');
    Route::post('binance', 'binanceIpn')->name('binance');
    Route::get('blockchain', 'blockchainIpn')->name('blockchain');
    Route::get('instamojo', 'instamojoIpn')->name('instamojo');
    Route::post('paytm', 'paytmIpn')->name('paytm');
    Route::post('razorpay', 'razorpayIpn')->name('razorpay');
    Route::post('twocheckout', 'twocheckoutIpn')->name('twocheckout');
});

// Site others
Route::get('theme-mode', [HomeController::class, 'themeMode'])->name('mode-theme');
Route::get('refresh-token', [HomeController::class, 'refreshToken']);

// Without auth
Route::get('notification-tune', [AppController::class, 'notificationTune'])->name('notification-tune');

// Site cron job
Route::get('site-cron', [CronJobController::class, 'runCronJobs'])->middleware('isDemo')->name('cron.job');
