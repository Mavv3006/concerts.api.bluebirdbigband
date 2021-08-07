<?php


namespace Database\Factories;


use App\Models\Place;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceFactory extends Factory
{
    protected $model = Place::class;

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'plz' => random_int(10000, 99999),
            'name' => $this->faker->city,
        ];
    }
}
