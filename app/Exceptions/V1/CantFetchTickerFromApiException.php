<?php

namespace App\Exceptions\V1;

class CantFetchTickerFromApiException extends \Exception implements JsonException
{
    use GetErrorCode;

    protected $errorCode = ERR_TICKER_API;

    protected $message = 'Cant get data from api';

    protected $code = 400;
}
