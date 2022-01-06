<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication(): Application
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['authorization' => "string"])]
    protected function getLoginHeader(): array
    {
        return $this->getAuthHeader($this->login()->access_token);
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
