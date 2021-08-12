<?php

namespace Tests;

use App\Models\User;
use App\Services\Auth\RegistrationService;

trait RegisterSuccessUser
{
    protected bool $initialized = false;
    protected RegistrationService $registrationService;
    protected string $successEmail = 'lorem-login-success@example.com';
    protected string $successPassword = 'demo12345';

    /**
     * Register our success user to db
     */
    protected function registerSuccessUser(): void
    {
        if (!$this->initialized) {
            // Load if not loaded
            $this->registrationService = app(RegistrationService::class);
            $this->initialized = true;
        }

        $successUserData = [
            "name" => "Success login user",
            "email" => $this->successEmail,
            "password" => $this->successPassword,
            "password_confirmation" => $this->successPassword,
        ];

        // We will remove our test user, just to be ensure that we will not get duplicates
        User::query()->where('email', $this->successEmail)->delete();

        // Then we will register our success user to test the login functional
        $this->registrationService->register($successUserData);
    }
}
