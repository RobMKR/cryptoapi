<?php

namespace App\Services\Exchange;

use App\Exceptions\V1\CantFetchListingsFromApiException;
use App\Exceptions\V1\CantFetchTickerFromApiException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class AlternativeApiService
{
    const COINS_URL = 'https://api.alternative.me/v2/listings';
    const TICKER_URL = 'https://api.alternative.me/v2/ticker/{id}/';

    /**
     * @param array $result
     * @param string|null $sort
     */
    private function sort(array &$result, ?string $sort): void
    {
        if ($sort === 'ASC') {
            usort($result, function ($a, $b) {
                return $a['name'] <=> $b['name'];
            });
        } else if ($sort === 'DESC') {
            usort($result, function ($a, $b) {
                return $b['name'] <=> $a['name'];
            });
        }
    }

    /**
     * @param $sort
     * @return array[]
     * @throws CantFetchListingsFromApiException
     */
    public function getCoins(?string $sort = null): array
    {
        $response = Http::get(self::COINS_URL);

        if ($response->failed()) {
            throw new CantFetchListingsFromApiException();
        }

        $json = $response->body();

        // I'm not sure why,
        // But Laravel Http/ GuzzleHttp and cUrl was cutting the last "}" character from the
        // string I'm getting from the api
        // So I will add it manually to be able to parse json normally
        // If you will have an issue on your machine, just remove this [. "}"] part and do normal decode
        $coinsData = json_decode($json . "}", 1);

        $result = array_map(function ($coin) {
            return [
                'id' => $coin['id'],
                'name' => $coin['name'],
                'code' => $coin['symbol'],
            ];
        }, $coinsData['data']);

        if ($sort) {
            $this->sort($result, $sort);
        }

        return $result;
    }

    /**
     * @param $id
     * @return array|mixed
     * @throws CantFetchTickerFromApiException
     */
    public function getTicker($id)
    {
        $response = Http::get(str_replace('{id}', $id, self::TICKER_URL));

        if ($response->failed()) {
            throw new CantFetchTickerFromApiException();
        }

        $ticker = $response->json();

        $ticker = $ticker['data'][$id];

        return [
            'id' => $ticker['id'],
            'code' => $ticker['symbol'],
            'price' => $ticker['quotes']['USD']['price'],
            'volume' => $ticker['quotes']['USD']['volume_24h'],
            'daily_change' => $ticker['quotes']['USD']['percentage_change_24h'],
            'last_updated' => $ticker['last_updated'],
            'cache_time' => Carbon::now()->timestamp
        ];
    }
}
