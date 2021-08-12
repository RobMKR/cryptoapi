<?php

namespace App\Services\Exchange;

use App\Contracts\ServiceHasCacheContract;
use App\Exceptions\V1\InvalidTickerRequestedException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class TickerService implements ServiceHasCacheContract
{
    protected CoinsService $coinService;
    protected AlternativeApiService $alternativeApiService;
    protected array $coins;

    public function __construct(CoinsService $coinsService, AlternativeApiService $alternativeApiService)
    {
        $this->coinService = $coinsService;
        $this->alternativeApiService = $alternativeApiService;
        $this->getCoins();
    }

    protected function getCoins()
    {
        $this->coins = $this->coinService->list();

        return $this;
    }

    /**
     * @param $_coin
     * @return bool
     */
    protected function coinIsValid($_coin)
    {
        foreach ($this->coins as $coin) {

            // Im checking the code with exactly match,
            // If there is no difference in lower or upper case,
            // then we can check with strtolower($coin['code']) === strtolower($_coin)
            // But now it is done with checking also case sensitivity
            if ($coin['code'] === $_coin) {
                // If we found the coin, stop the loop
                return true;
            }
        }

        return false;
    }

    /**
     * @param $code
     * @return string
     */
    public function getCacheKey($code)
    {
        return "ticker.$code";
    }

    /**
     * @param $code
     * @return mixed
     */
    private function retrieveFromCache($code)
    {
        $result = Cache::get($this->getCacheKey($code));

        $result['last_updated'] = $result['cache_time'];
        unset($result['cache_time']);
        unset($result['id']);

        return $result;
    }

    /**
     * @return array|mixed
     * @throws InvalidTickerRequestedException
     * @throws \App\Exceptions\V1\CantFetchTickerFromApiException
     */
    private function retrieveFromApiAndCacheResults($code)
    {
        $id = $this->coinService->getIdFromCode($code);

        $result = $this->alternativeApiService->getTicker($id);

        // Cache the result for 5 minutes if no data found in cache
        Cache::put($this->getCacheKey($code), $result, 300);

        unset($result['cache_time']);
        unset($result['id']);

        return $result;
    }

    /**
     * @param $code
     * @return array
     * @throws InvalidTickerRequestedException
     */
    public function getInfoByCode($code)
    {
        if (!$this->coinIsValid($code)) {
            throw new InvalidTickerRequestedException();
        }

        if (Cache::has($this->getCacheKey($code))) {
            return $this->retrieveFromCache($code);
        }

        return $this->retrieveFromApiAndCacheResults($code);
    }
}
