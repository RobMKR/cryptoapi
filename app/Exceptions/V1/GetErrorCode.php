<?php

namespace App\Exceptions\V1;

trait GetErrorCode
{
    /**
     * Get the defined error code
     *
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode ?? 100;
    }
}
