<?php

namespace App\Http\Controllers\Api\V1\Exchange;

use App\Http\Requests\V1\Exchange\Coins\ListRequest;
use App\Services\Exchange\CoinsService;
use App\Services\Response\ResponseService;

class CoinsController
{
    /**
     * @param ListRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(ListRequest $request, CoinsService $coinsService)
    {
        $coins = array_map(function ($coin) {
            // We will remove ids from response
            return [
                'name' => $coin['name'],
                'code' => $coin['code']
            ];
        }, $coinsService->list($request->input('sort', 'ASC')));

        return ResponseService::data($coins);
    }
}
