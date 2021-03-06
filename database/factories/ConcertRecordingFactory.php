<?php

namespace Database\Factories;

use App\Models\Concert;
use App\Models\ConcertRecording;
use App\Models\SongType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConcertRecordingFactory extends Factory
{
    protected $model = ConcertRecording::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'file_name' => "test.mp3",
            'description' => $this->faker->name,
            'size' => mt_rand(5 * 10, 25 * 10) / 10,
            'concert_date' => Concert::all()->random()->date(),
            'type' => SongType::all()->random()->id
        ];
    }
}
