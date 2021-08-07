<?php

namespace Database\Seeders;

use App\Models\Band;
use App\Models\Concert;
use App\Models\Place;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class ConcertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            Concert::factory()
                ->count(25)
                ->create();
        } catch (QueryException $ex) {
            //
        }
    }
}
