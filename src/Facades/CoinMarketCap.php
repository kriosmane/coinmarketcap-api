<?php

namespace KriosMane\CoinMarketCap\Facades;

use Illuminate\Support\Facades\Facade;
use KriosMane\CoinMarketCap\CoinMarketCap as CoinMarketCapClass;    

class CoinMarketCap extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return CoinMarketCapClass::class;
    }
}