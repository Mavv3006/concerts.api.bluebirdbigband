<?php

namespace Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_login_successful()
    {
        User::factory()->create(['name' => 'test', 'password' => Hash::make('test')]);

        $this
            ->json('POST', 'auth/login', [
                'name' => "test",
                'password' => "test"
            ])
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
            ->json('POST', 'auth/login', ['name' => "test"])
            ->assertResponseStatus(400);
    }

    public function test_login_validation_error_name()
    {
        User::factory()->create(['name' => 'test', 'password' => Hash::make('test')]);

        $this
            ->json('POST', 'auth/login', ["password" => "test"])
            ->seeStatusCode(400)
            ->seeJsonStructure(['error', 'message']);
    }

    public function test_me_successful()
    {
        $login = $this->login();
        $this
            ->get('auth/me', headers: $this->getAuthHeader($login->access_token))
            ->seeStatusCode(200)
            ->seeJsonStructure(['name', 'id', 'created_at', 'updated_at']);
    }

    public function test_logout_successful()
    {
        $login = $this->login();
        $this->get('auth/logout', headers: $this->getAuthHeader($login->access_token));
        var_dump($this->response->getContent());
        $this->seeStatusCode(200)
            ->seeJsonStructure(['message']);
    }

    public function test_logout_auth_route_protection()
    {
        $this
            ->get('auth/logout')
            ->seeStatusCode(401)
            ->seeJsonStructure(['error']);
    }

    public function test_me_auth_route_protection()
    {
        $this
            ->get('auth/me')
            ->seeStatusCode(401)
            ->seeJsonStructure(['error']);
    }

    /**
     * @return mixed the JWT to use for logging in
     */
    private function login(): mixed
    {
        User::factory()->create(['name' => 'test', 'password' => Hash::make('test')]);
        $content = $this
            ->post('auth/login', ['name' => "test", 'password' => "test"])
            ->response
            ->getContent();
        return json_decode($content);
    }

    /**
     * @param string $token
     * @return string[]
     */
    #[ArrayShape(['authorization' => "string"])]
    private function getAuthHeader(string $token): array
    {
        return ['authorization' => 'bearer ' . base64_encode($token)];
    }
}
