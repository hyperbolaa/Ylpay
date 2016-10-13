<?php
namespace Hyperbolaa\Ylpay;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;

class YlpayServiceProvider extends ServiceProvider
{

    /**
     * boot process
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source_config = realpath(__DIR__ . '/../../config/config.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                $source_config => config_path('ylpay.php'),
            ]);
        }

        $this->mergeConfigFrom($source_config, 'ylpay');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ylpay.mobile', function ($app) {
            $alipay = new Mobile\SdkPayment();
            $alipay->setMerchantId($app->config->get('ylpay.merchant_id'))
                ->setMode($app->config->get('ylpay.mode'))
                ->setSignType($app->config->get('ylpay.sign_type'))
                ->setPrivateKeyPath($app->config->get('ylpay.private_key_path'))
                ->setPublicKeyPath($app->config->get('ylpay.public_key_path'))
                ->setNotifyUrl($app->config->get('ylpay.notify_url'));
            return $alipay;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'ylpay.mobile',
        ];
    }
}
