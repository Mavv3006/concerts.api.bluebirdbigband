<?php

namespace Http\Controllers;

use App\Models\Concert;
use App\Models\ConcertRecording;
use App\Models\Song;
use App\Models\SongType;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class DownloadControllerTest extends TestCase
{
    use DatabaseMigrations;

    private string $songs_url = 'download/songs';
    private string $recordings_url = 'download/recordings';

    public function test_get_all_songs_correct()
    {
        $json_structure = [
            [
                'arranger',
                'author',
                'file_name',
                'genre',
                'title'
            ]
        ];

        SongType::factory()->create();
        Song::factory()->count(3)->create();

        $this
            ->get($this->songs_url, $this->getLoginHeader())
            ->seeStatusCode(200)
            ->seeHeader('content-type', 'application/json')
            ->seeJsonStructure($json_structure);
    }

    public function test_all_songs_force_use_auth()
    {
        $this
            ->get($this->songs_url)
            ->seeStatusCode(401)
            ->seeHeader('content-type', 'application/json')
            ->seeJsonStructure(['error']);
    }

    public function test_all_songs_no_songs()
    {
        $this
            ->get($this->songs_url, $this->getLoginHeader())
            ->seeStatusCode(200)
            ->seeHeader('content-type', 'application/json')
            ->seeJsonStructure(['*' => []]);
    }

    public function test_concert_recordings_correct()
    {
        $json_structure = [
            '*' => [
                'concert' => [
                    'date',
                    'description',
                    'place'
                ],
                'files' => [
                    '*' => [
                        'description',
                        'file_size',
                        'file_name'
                    ]
                ]
            ]
        ];

        Concert::factory()->create();
        $concert = Concert::first();
        SongType::factory()->create();
        $concertRecording = ConcertRecording::factory()->create();

        $json_exact = [
            [
                'concert' => [
                    'description' => $concert->place_description,
                    'date' => $concert->date(),
                    'place' => $concert->place->name
                ],
                'files' => [
                    [
                        'description' => $concertRecording->description,
                        'file_size' => $concertRecording->size,
                        'file_name' => $concertRecording->file_name
                    ]
                ]
            ]
        ];

        $this
            ->get($this->recordings_url, $this->getLoginHeader())
            ->seeStatusCode(200)
            ->seeHeader('content-type', 'application/json')
            ->seeJsonStructure($json_structure)
            ->seeJsonEquals($json_exact);
    }

    public function test_concert_recordings_force_use_auth()
    {
        $this
            ->get($this->recordings_url)
            ->seeStatusCode(401)
            ->seeHeader('content-type', 'application/json')
            ->seeJsonStructure(['error']);
    }
}
