<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SongFactory extends Factory
{

    public function definition()
    {
        return [
            'file_name' => 'fever.mp3',
            'song_name' => 'Fever',
            'genre' => 'Swing',
            'arranger' => 'Roger Holmes',
            'author' => 'J. Davenport, E. Cooley',
            'type' => '1',
            'size' => $this->faker->randomNumber(2)
        ];
    }
}
