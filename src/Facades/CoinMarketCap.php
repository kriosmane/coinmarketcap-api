<?php

namespace KriosMane\CoinMarketCap\Facades;

use Illuminate\Support\Facades\Facade;

class CoinMarketCap extends Facade
{
    /**
     * Get the registered name of the component
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'coin-market-cap';
    }
}