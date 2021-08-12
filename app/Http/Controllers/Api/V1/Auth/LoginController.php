<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Exceptions\V1\WrongCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use App\Services\Response\ResponseService;
use App\Services\User\UserService;

class LoginController extends Controller
{
    const FIELDS = [
        'email',
        'password'
    ];

    /**
     * @param LoginRequest $request
     * @param LoginService $loginService
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request, LoginService $loginService, UserService $userService)
    {
        try {
            // Trying to login the user
            // If it was succeeded then respond with JWT token
            $payload = $loginService->login($request->only(self::FIELDS));

            return ResponseService::data($payload, [
                'me' => $userService->me()
            ]);
        } catch (WrongCredentialsException $exception) {
            return ResponseService::errorMessage($exception->getMessage(), ERR_WRONG_CREDENTIALS, 422);
        }
    }
}
