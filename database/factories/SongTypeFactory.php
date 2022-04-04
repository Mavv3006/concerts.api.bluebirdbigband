<?php

namespace Database\Factories;

use App\Models\SongType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SongTypeFactory extends Factory
{

    protected $model = SongType::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'type' => $this->faker->colorName,
            'folder_name' => 'songs'
        ];
    }
}
