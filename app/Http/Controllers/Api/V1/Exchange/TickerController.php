<?php

namespace App\Http\Controllers\Api\V1\Exchange;

use App\Services\Exchange\TickerService;
use App\Services\Response\ResponseService;

class TickerController
{
    /**
     * @param TickerService $tickerService
     * @param $coinCode
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\V1\InvalidTickerRequestedException
     */
    public function __invoke(TickerService $tickerService, $coinCode)
    {
        return ResponseService::data($tickerService->getInfoByCode($coinCode));
    }
}
