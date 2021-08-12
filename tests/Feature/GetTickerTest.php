<?php

namespace Tests\Feature;

use Tests\GetAuthToken;
use Tests\TestCase;

class GetTickerTest extends TestCase
{
    use GetAuthToken;

    const URL = 'api/v1/exchange/ticker/{id}';
    const METHOD = 'GET';
    const HEADERS = ['Accept' => 'application/json'];

    /**
     * Test case when no input is specified on login call
     */
    public function testInvalidCoinParam()
    {
        $headers = array_merge(self::HEADERS, [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        // NETT stands for Non Existing Test Token
        // Likely NFT :D
        $url = str_replace('{id}', 'NETT', self::URL);

        $this->json(self::METHOD, $url, [], $headers)
            ->assertStatus(404)
            ->assertJsonFragment(["type" => "ERR_MESSAGE"])
            ->assertJsonFragment(["error" => ERR_TICKER_NOT_FOUND])
            ->assertJsonFragment(["error_message" => 'Ticker you are requested was not found in our database'])
            ->assertJsonStructure([
                "type",
                "error",
                "error_message",
                "timestamp",
            ]);
    }

    public function testCoinsSuccess()
    {
        $headers = array_merge(self::HEADERS, [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        // We will use BTC to be sure that api works fine
        $url = str_replace('{id}', 'BTC', self::URL);

        $this->json(self::METHOD, $url, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "code",
                    "price",
                    "volume",
                    "daily_change",
                    "last_updated",
                ],
                "metadata" => []
            ]);
    }
}
