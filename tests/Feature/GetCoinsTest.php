<?php

namespace Tests\Feature;

use Tests\GetAuthToken;
use Tests\TestCase;

class GetCoinsTest extends TestCase
{
    use GetAuthToken;

    const URL = 'api/v1/exchange/coins?';
    const METHOD = 'GET';
    const HEADERS = ['Accept' => 'application/json'];

    /**
     * Test case when no input is specified on login call
     */
    public function testCoinsInvalidSortParam()
    {
        $headers = array_merge(self::HEADERS, [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $data = [
            'sort' => 'somethingNotAscAndNotDesc'
        ];

        $this->json(self::METHOD, self::URL, $data, $headers)
            ->assertStatus(422)
            ->assertJson([
                "type" => "ERR_INVALID",
                "errors" => [
                    "sort" => ["The selected sort is invalid."]
                ]
            ]);
    }

    public function testCoinsSuccess()
    {
        $headers = array_merge(self::HEADERS, [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $this->json(self::METHOD, self::URL, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    '*' => [
                        "code",
                        "name"
                    ]
                ],
                "metadata" => []
            ]);
    }
}
