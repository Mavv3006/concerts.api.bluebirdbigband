<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['name' => "string", 'password' => "string"])]
    public function definition(): array
    {
        return [
            'name' => "test",
            'password' => Hash::make('test'),
        ];
    }
}
