<?php

namespace App\Exceptions\V1;

class CantFetchListingsFromApiException extends \Exception implements JsonException
{
    use GetErrorCode;

    protected $errorCode = ERR_COINS_API;

    protected $message = 'Cant get data from api';

    protected $code = 400;
}
