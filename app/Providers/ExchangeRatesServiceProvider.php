<?php

namespace App\Providers;

use App\Services\ExchangeRates\ExchangeRatesService;
use Illuminate\Support\ServiceProvider;

class ExchangeRatesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('App\Services\ExchangeRates\interfaces\IExchangeRatesService', function () {
            return new ExchangeRatesService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
