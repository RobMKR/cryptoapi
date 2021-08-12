<?php

namespace App\Services\Auth;

use App\Exceptions\V1\WrongCredentialsException;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    // We will just set some long TTL
    // Because we didn't implement refresh token logic,
    // Because of no need in this small project ;)
    // We just realize the reg/login features
    // Without taking it too serious
    const TTL = 600000;

    /**
     * @param array $credentials
     * @return array
     * @throws WrongCredentialsException
     */
    public function login(array $credentials): array
    {
        if (! $token = Auth::setTTL(self::TTL)->attempt($credentials)) {
            throw new WrongCredentialsException();
        }

        return [
            'token' => $token,
            'expires_in' => Auth::factory()->getTTL()  * 60
        ];
    }
}
