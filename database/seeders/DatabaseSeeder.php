<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        $this->call(PlaceSeeder::class);
        $this->call(BandSeeder::class);
        $this->call(ConcertSeeder::class);
        $this->call(UserSeeder::class);
    }
}
