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
        try {
            ConcertRecording::factory()
                ->count(25)
                ->create();
        } catch (QueryException $e) {
            //
        }
    }
}
