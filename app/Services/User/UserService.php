<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * For now we will get the whole user object from the session
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function me()
    {
        return Auth::user();
    }
}
