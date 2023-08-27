<?php

namespace App\Services\Contracts;

interface StockServiceInterface
{
    public function getHistoricalData(): array;
}
