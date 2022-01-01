<?php

namespace Database\Factories;

use App\Models\Concert;
use App\Models\ConcertRecording;
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
            'file_name' => $this->faker->slug(2, false),
            'song_name' => $this->faker->name,
            'size' => mt_rand(5 * 10, 25 * 10) / 10,
            'concerts_date' => Concert::factory()->create()->date()
        ];
    }
}
