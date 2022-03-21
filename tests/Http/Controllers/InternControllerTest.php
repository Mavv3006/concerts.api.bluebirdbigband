<?php

namespace Http\Controllers;

use App\Models\Concert;
use App\Models\ConcertRecording;
use App\Models\SongType;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;


class InternControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_intern_resources()
    {
        $json_response_structure = [
            '*' => [
                'name',
                'emails' => [
                    '*' => [
                        'name',
                        'email'
                    ]
                ]
            ]
        ];
        $json_response_exact = [
            [
                'name' => 'ALLE (Midi / Maxi)',
                'emails' => [
                    ['name' => 'Alle (Midi/Maxi)', 'email' => 'MusikerInnen@BlueBirdBigBand.de']
                ],
            ],
            [
                'name' => 'MAXI',
                'emails' => [
                    ['name' => 'Alle Maxi-Mitglieder', 'email' => 'maxi@BlueBirdBigBand.de'],
                    ['name' => 'Saxophonsatz', 'email' => 'maxi-Saxophone@BlueBirdBigBand.de'],
                    ['name' => 'Posaunensatz', 'email' => 'maxi-Posaunen@BlueBirdBigBand.de'],
                    ['name' => 'Trompetensatz', 'email' => 'maxi-Trompeten@BlueBirdBigBand.de'],
                    ['name' => 'Rhythmusgruppe', 'email' => 'maxi-Rhythmusgruppe@BlueBirdBigBand.de'],
                ]
            ],
            [
                'name' => 'MIDI',
                'emails' => [
                    ['name' => 'Alle Midi-Mitglieder', 'email' => 'midi@BlueBirdBigBand.de'],
                    ['name' => 'Saxophonsatz', 'email' => 'midi-Saxophone@BlueBirdBigBand.de'],
                    ['name' => 'Posaunensatz', 'email' => 'midi-Posaunen@BlueBirdBigBand.de'],
                    ['name' => 'Trompetensatz', 'email' => 'midi-Trompeten@BlueBirdBigBand.de'],
                    ['name' => 'Rhythmusgruppe', 'email' => 'midi-Rhythmusgruppe@BlueBirdBigBand.de'],
                ]
            ],
            [
                'name' => 'SONSTIGE',
                'emails' => [
                    ['name' => 'Bandleader', 'email' => 'Bandleiter@BlueBirdBigBand.de'],
                    ['name' => 'Webmaster', 'email' => 'webadmin@bluebirdbigband.de']
                ]
            ]
        ];
        $this
            ->get('intern/basics', $this->getLoginHeader())
            ->seeStatusCode(200)
            ->seeJsonStructure($json_response_structure)
            ->seeJsonEquals($json_response_exact);
    }

    public function test_downloads()
    {
        Concert::factory()->count(3)->create();
        SongType::factory()->create();
        ConcertRecording::factory()->count(6)->create();

        $this->get('intern/downloads', $this->getLoginHeader())
            ->seeStatusCode(200)
            ->seeJsonStructure([
                [
                    'concert' => [
                        'date',
                        'description',
                        'place'
                    ],
                    'files' => [
                        [
                            'description',
                            'file_size',
                            'file_name'
                        ]
                    ]
                ]
            ]);
    }

    public function test_downloads_without_files()
    {
        Concert::factory()->count(3)->create();

        $this
            ->get('intern/downloads', $this->getLoginHeader())
            ->seeStatusCode(200)
            ->seeJsonEquals([]);
    }

    public function test_downloads_only_concerts_with_files()
    {
        Concert::factory()->count(3)->create();
        SongType::factory()->create();
        ConcertRecording::factory()->count(1)->create();

        $recording = ConcertRecording::first();
        $concert = $recording->concert;

        $this
            ->get('intern/downloads', $this->getLoginHeader())
            ->seeStatusCode(200)
            ->seeJsonEquals([
                [
                    'concert' => [
                        'date' => $concert->date(),
                        'description' => $concert->place_description,
                        'place' => $concert->place->name
                    ],
                    'files' => [
                        [
                            'description' => $recording->description,
                            'file_name' => $recording->file_name,
                            'file_size' => $recording->size
                        ]
                    ]
                ]
            ]);
    }

    public function test_downloads_without_logging_in()
    {
        $this
            ->get('intern/downloads')
            ->seeStatusCode(401)
            ->seeJsonStructure(['error']);
    }

    public function test_basics_without_logging_in()
    {
        $this
            ->get('intern/basics')
            ->seeStatusCode(401)
            ->seeJsonStructure([
                'error',
            ]);
    }
}
