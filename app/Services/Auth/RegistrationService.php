<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class RegistrationService
{
    /**
     * @param array $data
     * @return User|Model
     */
    public function register(array $data): User
    {
        $insert = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ];

        return User::query()->create($insert);
    }
}
