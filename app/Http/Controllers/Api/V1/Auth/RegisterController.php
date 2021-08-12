<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Models\User;
use App\Services\Auth\RegistrationService;
use App\Services\Response\ResponseService;

class RegisterController extends Controller
{
    const FIELDS = [
        'email',
        'name',
        'password'
    ];

    /**
     * @param RegisterRequest $request
     * @param RegistrationService $registrationService
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegisterRequest $request, RegistrationService $registrationService)
    {
        return ResponseService::data(
            $registrationService->register(
                $request->only(self::FIELDS)
            )
        );
    }
}
