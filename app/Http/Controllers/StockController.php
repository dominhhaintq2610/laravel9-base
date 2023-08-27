<?php

namespace App\Http\Controllers;

use App\Services\StockService;
use Inertia\Inertia;

class StockController extends Controller
{
    private StockService $stockService;

    /**
     * @param StockService $stockService
     */
    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(): \Inertia\Response
    {
        $historicalData = $this->stockService->getHistoricalData();

        return Inertia::render('Stock/Index', [
            'historicalData' => $historicalData
        ]);
    }
}
