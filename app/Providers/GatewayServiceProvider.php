<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Mollie\Laravel\Facades\Mollie;
use Remotelywork\Installer\Repository\App;
use Schema;

class GatewayServiceProvider extends ServiceProvider
{
    /**
     * Register modules.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap modules.
     *
     * @return void
     */
    public function boot()
    {

        if (App::dbConnectionCheck() && Schema::hasTable('gateways')) {
            // =============== paypal ==============
            $paypalCredential = gateway_info('paypal');
            $paystackCredential = gateway_info('paystack');
            $perfectmoneyCredential = gateway_info('perfectmoney');
            $coinbaseCredential = gateway_info('coinbase');
            $coinremitterCredential = gateway_info('coinremitter');

            $paypalInfo = [
                'paypal.mode' => $paypalCredential->mode,
            ];

            if ($paypalCredential->mode != 'sandbox') {
                // Live mode: App ID is optional - PayPal sets it automatically from access token
                $paypalInfo = array_merge($paypalInfo, [
                    'paypal.live.app_id' => $paypalCredential->app_id ?? '',
                    'paypal.live.client_id' => trim($paypalCredential->client_id ?? ''),
                    'paypal.live.client_secret' => trim($paypalCredential->client_secret ?? ''),
                ]);
            } else {
                // Sandbox mode: Use default sandbox App ID if not provided
                $paypalInfo = array_merge($paypalInfo, [
                    'paypal.sandbox.app_id' => $paypalCredential->app_id ?? 'APP-80W284485P519543T',
                    'paypal.sandbox.client_id' => trim($paypalCredential->client_id ?? ''),
                    'paypal.sandbox.client_secret' => trim($paypalCredential->client_secret ?? ''),
                ]);
            }

            config()->set($paypalInfo);
            // =============== Mollie ==============
            $mollieCredential = gateway_info('mollie');
            Mollie::api()->setApiKey($mollieCredential->api_key);
            // =============== Paystack ==============
            config()->set([
                'paystack.publicKey' => $paystackCredential->public_key,
                'paystack.merchantEmail' => $paystackCredential->merchant_email,
                'paystack.secretKey' => $paystackCredential->secret_key,
            ]);
            // =============== Perfect Money ==============
            config()->set([
                'perfectmoney.account_id' => $perfectmoneyCredential->PM_ACCOUNTID,
                'perfectmoney.passphrase' => $perfectmoneyCredential->PM_PASSPHRASE,
                'perfectmoney.marchant_id' => $perfectmoneyCredential->PM_MARCHANTID,
            ]);
            // =============== Coinbase ==============
            config()->set([
                'coinbase.apiKey' => $coinbaseCredential->apiKey,
                'coinbase.webhookSecret' => $coinbaseCredential->webhookSecret,
                'coinbase.apiVersion' => $coinbaseCredential->apiVersion,
            ]);

        }
    }
}
