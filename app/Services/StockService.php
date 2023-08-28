<?php

namespace App\Services;

use App\Services\Contracts\StockServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class StockService implements StockServiceInterface
{
    /**
     * @throws GuzzleException
     */
    public function getHistoricalData(array $conditions): array
    {
        if (!empty($conditions['symbol']) && !empty($conditions['from']) && !empty($conditions['to'])) {
            $symbol = strtoupper($conditions['symbol']);
            $from = strtotime($conditions['from']);
            $to = strtotime($conditions['to']);

            $client = new Client();
            $url = "https://services.entrade.com.vn/chart-api/v2/ohlcs/stock?from=${from}&to=${to}&symbol=${symbol}&resolution=1D";
            $response = $client->get($url);
            $stockData = json_decode($response->getBody(), true);

            return $this->transformStockData($stockData);
        }

        return [];
    }

    private function transformStockData(array $data): array
    {
        $replaceKeys = [
            't' => 'time',
            'o' => 'open',
            'h' => 'high',
            'l' => 'low',
            'c' => 'close',
            'v' => 'volume'
        ];

        $formattedData = [];

        foreach ($replaceKeys as $oldKey => $newKey) {
            $formattedData[$newKey] = $data[$oldKey];
        }

        return $formattedData;
    }
}
