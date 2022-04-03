<?php

namespace Http\Controllers;

use App\Models\Concert;
use App\Models\ConcertRecording;
use App\Models\Song;
use App\Models\SongType;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class ConcertRecordingsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_download_the_right_file()
    {
        Concert::factory()->create();
        SongType::factory()->create();

        $storage = Storage::fake('local');
        $file_name = "test_get_one_file.mp3";
        $file = File::create($file_name, 100);
        $file_path = $file->storeAs('recordings', $file_name, 'local');
        ConcertRecording::factory()->create(['file_name' => $file_name]);

        $response = $this->get('download/recording?file_name=' . $file_name, $this->getLoginHeader());

        $response
            ->seeStatusCode(200)
            ->seeHeader('content-type', 'audio/mpeg');

        Storage::shouldReceive('disk')
            ->with('local')
            ->andReturn($storage)
            ->shouldReceive('download')
            ->with($file_path)
            ->andReturn($file);
    }

    public function test_fail_download()
    {
        Storage::fake('local');
        $file_name = 'test.mp3';
        File::create($file_name, 100)->storeAs('recordings', $file_name, 'local');
        Song::factory()->create(['file_name' => $file_name]);

        $this->get('download/recording?file_name=bla_bla', $this->getLoginHeader())
            ->seeStatusCode(404)
            ->seeHeader('content-type', 'application/json')
            ->seeJsonStructure(['error']);
    }

    public function test_auth()
    {
        $this
            ->get('download/recording?file_name=test.mp3')
            ->seeStatusCode(401)
            ->seeHeader('content-type', 'application/json')
            ->seeJsonStructure(['error']);
    }

    public function test_no_query_parameter()
    {
        Storage::fake('local');
        $file_name = 'test.mp3';
        File::create($file_name, 100)->storeAs('recordings', $file_name, 'local');
        Song::factory()->create(['file_name' => $file_name]);

        $this
            ->get('download/recording', $this->getLoginHeader())
            ->seeStatusCode(400)
            ->seeJsonStructure(['error', 'message']);
    }

    public function test_download_gitkeep()
    {
        Storage::fake('local');
        $file_name = '.gitkeep';
        File::create($file_name, 100)->storeAs('recordings', $file_name, 'local');

        $this
            ->get('download/recording?file_name=' . $file_name, $this->getLoginHeader())
            ->seeStatusCode(404);
    }
}
