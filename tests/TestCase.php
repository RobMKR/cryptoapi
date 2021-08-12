<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const EXAMPLE_EMAIL = "lorem@example.com";

    /**
     * Setup testing environment
     */
    protected function setUp() : void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');

        // Each time running tests we will remove example user and then recreate again
        User::query()->where('email', self::EXAMPLE_EMAIL)->delete();

        // We will create an example user
        // To be able to test uniqueness validation
        User::query()->create([
            "name" => "Lorem Ipsum",
            "email" => self::EXAMPLE_EMAIL,
            "password" => Hash::make("demo12345")
        ]);
    }
}
