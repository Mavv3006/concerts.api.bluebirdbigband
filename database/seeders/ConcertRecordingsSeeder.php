<?php

namespace Database\Seeders;

use App\Models\ConcertRecording;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class ConcertRecordingsSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        for ($i = 0; $i < 25; $i++) {
            try {
                ConcertRecording::factory()->create();
            } catch (QueryException $e) {
                print_r("(" . $i . ") Failed to create " . ConcertRecording::class . "\nMessage: " . $e->getMessage() . "\n\n");
            }
        }
    }
}
