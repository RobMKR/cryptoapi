<?php

namespace App\Services\Exchange;

use App\Contracts\ServiceHasCacheContract;
use App\Exceptions\V1\InvalidTickerRequestedException;
use Illuminate\Support\Facades\Cache;

class CoinsService implements ServiceHasCacheContract
{
    protected AlternativeApiService $alternativeApiService;

    /**
     * CoinsService constructor.
     * @param AlternativeApiService $alternativeApiService
     */
    public function __construct(AlternativeApiService $alternativeApiService)
    {
        $this->alternativeApiService = $alternativeApiService;
    }

    /**
     * @param $sort
     * @return string
     */
    public function getCacheKey($sort) {
        if (!$sort) {
            $sort = 'none';
        }

        return "coins.sort=$sort";
    }

    /**
     * @param $code
     * @return mixed
     * @throws InvalidTickerRequestedException
     */
    public function getIdFromCode($code)
    {
        foreach ($this->list() as $item) {
            if ($item['code'] === $code) {
                return $item['id'];
            }
        }

        throw new InvalidTickerRequestedException();
    }

    /**
     * @param string|null $sort
     * @return array
     */
    public function list(?string $sort = null): array
    {
        // I think something I got wrong,
        // But /(the validity for tickers is 5 minutes, while the available coins don't expire)./
        // Anyway I will refresh the cache each 12 hours for example, just to be
        // sure that all new currencies we can get at least twice a day
        return Cache::remember($this->getCacheKey($sort), 43200, function () use ($sort) {
            return $this->alternativeApiService->getCoins($sort);
        });
    }
}
