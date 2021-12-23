<?php

namespace Http\Controllers;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_login_successful()
    {
        User::factory()->create(['name' => 'test']);

        $this->json('POST', 'auth/login', [
            'name' => "test",
            'password' => "test"
        ])->assertResponseOk();
    }

    public function test_login_validation_error()
    {
        User::factory()->create(['name' => 'test']);

        $this->json('POST', 'auth/login', [
            'name' => "test",
            'password' => "test"
        ])->assertResponseOk();
    }
}
