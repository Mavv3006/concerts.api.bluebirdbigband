<?php

namespace Database\Seeders;

use App\Models\SongType;
use Illuminate\Database\Seeder;

class SongTypeSeeder extends Seeder
{
    public function run()
    {
        SongType::factory()->create(['type' => 'song']);
        SongType::factory()->create(['type' => 'recording', 'folder_name' => 'recordings']);
    }
}
