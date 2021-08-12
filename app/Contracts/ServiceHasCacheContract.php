<?php

namespace App\Contracts;

interface ServiceHasCacheContract
{
    public function getCacheKey($part);
}
