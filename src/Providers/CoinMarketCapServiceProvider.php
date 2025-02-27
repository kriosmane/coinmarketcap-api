<?php

namespace Kriosmane\CoinMarketCap\Providers;

use Kriosmane\CoinMarketCap\CoinMarketCap;
use Illuminate\Support\ServiceProvider;

class CoinMarketCapServiceProvider extends ServiceProvider
{   
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {          
       /**
         *  Publish the configuration file (tag: config)
         */
        $this->publishes([
            __DIR__.'/../../config/coinmarketcap.php' => config_path('coinmarketcap.php'),
        ], 'config');

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/coinmarketcap.php', 'coinmarketcap');

        $this->app->singleton(CoinMarketCap::class, function ($app) {
            return new CoinMarketCap(config('coinmarketcap'));
        });
    }
}