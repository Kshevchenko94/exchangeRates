<?php

namespace App\Services\ExchangeRates\interfaces;

interface IExchangeRatesService
{
    public function getList(string $date): array;
}
