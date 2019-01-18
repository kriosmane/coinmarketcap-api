<?php

namespace KriosMane\CoinMarketCap\Providers;

use KriosMane\CoinMarketCap\Api;

use Illuminate\Support\ServiceProvider;

class CoinMarketCapServiceProvider extends ServiceProvider
{   

    /*
    * Indicates if loading of the provider is deferred.
    *
    * @var bool
    */
    protected $defer = true;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {   

        $config = realpath(__DIR__.'/../config/coinmarketcap.php');

        $this->publishes([

            $config => config_path('coinmarketcap.php')

        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('coinmarketcap', function() {

            return new Api();
            
        });
    }

    /**
    * Get the services provided by the provider
    * @return array
    */
    public function provides()
    {
        return ['coinmarketcap'];
    }
}
