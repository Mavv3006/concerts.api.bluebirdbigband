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
        $user = User::factory()->create(['name' => 'test']);

        $this->json('POST', 'login', [
            'name' => $user->name,
            'password' => $user->password
        ])->seeJsonContains([
//                'access_token' => $token,
            'token_type' => 'bearer',
//                'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
