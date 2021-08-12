<?php

namespace App\Exceptions\V1;

/**
 * Just for type
 *  To be able to respond with json when such exception will be threw
 *
 * Interface JsonException
 * @package App\Exceptions\V1
 */
interface JsonException
{
    public function getErrorCode();
}
