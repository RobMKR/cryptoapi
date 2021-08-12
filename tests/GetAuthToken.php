<?php

namespace Tests;

use App\Services\Auth\LoginService;

trait GetAuthToken
{
    use RegisterSuccessUser;

    /**
     * @var string|null
     */
    protected static $token;

    /**
     * Get token and store to static variable $token
     *
     * @throws \App\Exceptions\V1\WrongCredentialsException
     */
    protected function init()
    {
        /** @var LoginService $loginService */
        $loginService = app(LoginService::class);

        $this->registerSuccessUser();

        $payload = $loginService->login([
            'email' => $this->successEmail,
            'password' => $this->successPassword
        ]);

        $this::$token = $payload['token'] ?? null;
    }

    /**
     * @return string|null
     * @throws \App\Exceptions\V1\WrongCredentialsException
     */
    protected function getToken()
    {
        if (!$this::$token) {
            $this->init();
        }

        return $this::$token;
    }
}
