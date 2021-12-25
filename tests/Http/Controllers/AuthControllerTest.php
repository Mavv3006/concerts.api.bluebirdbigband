<?php

namespace Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_login_successful()
    {
        User::factory()->create(['name' => 'test', 'password' => Hash::make('test')]);

        $this->json('POST', 'auth/login', [
            'name' => "test",
            'password' => "test"
        ]);
        $this->assertResponseOk();
        $this->seeJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    public function test_login_validation_error_password()
    {
        User::factory()->create(['name' => 'test', 'password' => Hash::make('test')]);

        $this->json('POST', 'auth/login', ['name' => "test"])
            ->assertResponseStatus(400);
    }

    public function test_login_validation_error_name()
    {
        User::factory()->create(['name' => 'test', 'password' => Hash::make('test')]);

        $this->json('POST', 'auth/login', ["password" => "test"])
            ->seeStatusCode(400)
            ->seeJsonStructure(['error', 'message']);
    }

    /**
     * @return string the JWT to use for logging in
     */
    private function login(): string
    {
        User::factory()->create(['name' => 'test', 'password' => Hash::make('test')]);
        return $this
            ->post('auth/login', ['name' => "test", 'password' => "test"])
            ->response
            ->getContent();
    }
}
