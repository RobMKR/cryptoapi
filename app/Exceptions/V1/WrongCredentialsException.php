<?php

namespace App\Exceptions\V1;

class WrongCredentialsException extends \Exception
{
    protected $message = 'Login or password is incorrect';
}
