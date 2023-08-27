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
    public function getHistoricalData(): array
    {
        $client = new Client();
        $response = $client->get('https://services.entrade.com.vn/chart-api/v2/ohlcs/stock?from=1672531200&to=1693008000&symbol=VND&resolution=1D');
        $stockData = json_decode($response->getBody(), true);

        return $this->transformStockData($stockData);
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
