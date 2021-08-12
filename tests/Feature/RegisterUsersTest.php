<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RegisterUsersTest extends TestCase
{
    const URL = 'api/v1/auth/register';
    const METHOD = 'POST';
    const HEADERS = ['Accept' => 'application/json'];
    const REGISTER_SUCCESS_EMAIL = 'lorem-success@example.com';

    /**
     * Test case when no input is specified on register call
     */
    public function testRequiredFieldsForRegistration()
    {
        $this->json(self::METHOD, self::URL, self::HEADERS)
            ->assertStatus(422)
            ->assertJson([
                "type" => "ERR_INVALID",
                "errors" => [
                    "name" => ["The name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    /**
     * Test case when password not confirmed
     */
    public function testRepeatPassword()
    {
        $userData = [
            "name" => "Lorem Ipsum 2",
            "email" => TestCase::EXAMPLE_EMAIL,
            "password" => "demo12345"
        ];

        $this->json(self::METHOD, self::URL, $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "type" => "ERR_INVALID",
                "errors" => [
                    "password" => ["The password confirmation does not match."],
                ]
            ]);
    }

    /**
     * Test for email uniqueness
     */
    public function testEmailNotUniqueForRegistration()
    {
        /**
         * @see TestCase::setUp()
         */
        $userWithNonUniqueEmail = [
            "name" => "Lorem Ipsum 2",
            "email" => TestCase::EXAMPLE_EMAIL,
            "password" => "demo12345"
        ];


        $this->json(self::METHOD, self::URL, $userWithNonUniqueEmail, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "type" => "ERR_INVALID",
                "errors" => [
                    "email" => ["The email has already been taken."],
                ]
            ]);
    }

    /**
     *
     */
    public function testRegistrationSuccess()
    {
        // We will remove our example user from database, to able to store and test again
        User::query()->where('email', self::REGISTER_SUCCESS_EMAIL)->delete();

        $successUserData = [
            "name" => "Lorem Ipsum Success",
            "email" => self::REGISTER_SUCCESS_EMAIL,
            "password" => "demo12345",
            "password_confirmation" => "demo12345",
        ];

        $this->json(self::METHOD, self::URL, $successUserData, self::HEADERS)
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "name",
                    "email",
                    "updated_at",
                    "created_at",
                    "id",
                ],
                "metadata"
            ]);
    }
}
