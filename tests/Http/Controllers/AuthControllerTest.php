<?php

namespace Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_login_with_wrong_credentials()
    {
        User::factory()->create(['name' => 'test', 'password' => Hash::make('test')]);

        $this
            ->post('auth/login', ['name' => 'test', 'password' => 'bla bla'])
            ->seeStatusCode(401)
            ->seeJsonStructure(['error']);
    }

    public function test_login_without_request_body()
    {
        $this
            ->post('auth/login')
            ->seeStatusCode(400)
            ->seeJsonStructure(['error', 'message']);
    }

    public function test_login_successful()
    {
        User::factory()->create(['name' => 'test', 'password' => Hash::make('test')]);

        $this
            ->post('auth/login', ['name' => "test", 'password' => "test"])
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'access_token',
                'token_type',
                'expires' => [
                    'in',
                    'at'
                ]
            ]);
    }

    public function test_login_validation_error_password()
    {
        User::factory()->create(['name' => 'test', 'password' => Hash::make('test')]);

        $this
            ->post('auth/login', ['name' => "test"])
            ->assertResponseStatus(400);
    }

    public function test_login_validation_error_name()
    {
        User::factory()->create(['name' => 'test', 'password' => Hash::make('test')]);

        $this
            ->post('auth/login', ["password" => "test"])
            ->seeStatusCode(400)
            ->seeJsonStructure(['error', 'message']);
    }

    public function test_logout_successful()
    {
        $this
            ->get('auth/logout', $this->getLoginHeader())
            ->seeStatusCode(200)
            ->seeJsonStructure(['message']);
    }

    public function test_logout_auth_route_protection()
    {
        $this
            ->get('auth/logout')
            ->seeStatusCode(401)
            ->seeJsonStructure(['error']);
    }
}
