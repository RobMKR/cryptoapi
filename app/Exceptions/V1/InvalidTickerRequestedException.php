<?php

namespace App\Exceptions\V1;

class InvalidTickerRequestedException extends \Exception implements JsonException
{
    use GetErrorCode;

    protected $errorCode = ERR_TICKER_NOT_FOUND;
    protected $message = 'Ticker you are requested was not found in our database';
    protected $code = 404;
}
