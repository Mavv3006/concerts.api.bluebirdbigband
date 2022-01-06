<?php

namespace Http\Controllers;

use App\Models\Concert;
use App\Models\ConcertRecording;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;


class InternControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_intern_resources()
    {
        $json_response_structure = [
            'emails' => [
                'all',
                'maxi' => [
                    'all',
                    'trumpet',
                    'trombone',
                    'saxophone',
                    'rhythm'
                ],
                'midi' => [
                    'all',
                    'trumpet',
                    'trombone',
                    'saxophone',
                    'rhythm'
                ],
                'other' => [
                    'bandleader',
                    'webadmin'
                ]
            ],
            'gigs' => [
                'bbbb',
                'dtb'
            ]
        ];
        $json_response_exact = [
            'emails' => [
                'all' => 'musikerinnen@bluebirdbigband.de',
                'maxi' => [
                    'all' => 'maxi@bluebirdbigband.de',
                    'trumpet' => 'maxi-Trompeten@bluebirdbigband.de',
                    'trombone' => 'maxi-Posaunen@bluebirdbigband.de',
                    'saxophone' => 'maxi-Saxophone@bluebirdbigband.de',
                    'rhythm' => 'maxi-Rhytmusgruppe@bluebirdbigband.de',
                ],
                'midi' => [
                    'all' => 'midi@bluebirdbigband.de',
                    'trumpet' => 'midi-Trompeten@bluebirdbigband.de',
                    'trombone' => 'midi-Posaunen@bluebirdbigband.de',
                    'saxophone' => 'midi-Saxophone@bluebirdbigband.de',
                    'rhythm' => 'midi-Rhytmusgruppe@bluebirdbigband.de',
                ],
                'other' => [
                    'bandleader' => 'bandleiter@bluebirdbigband.de',
                    'webadmin' => 'webadmin@bluebirdbigband.de'
                ]
            ],
            'gigs' => [
                'bbbb' => 'https://www.google.com',
                'dtb' => 'https://www.google.com'
            ]
        ];
        $this
            ->get('intern/basics')
            ->seeStatusCode(200)
            ->seeJsonStructure($json_response_structure)
            ->seeJsonEquals($json_response_exact);
    }

    public function test_downloads()
    {
        Concert::factory()->count(3)->create();
        ConcertRecording::factory()->count(6)->create();

        $this->get('intern/downloads');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
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
            ->get('intern/downloads')
            ->seeStatusCode(200)
            ->seeJsonEquals([]);
    }

    public function test_downloads_only_concerts_with_files()
    {
        Concert::factory()->count(3)->create();
        ConcertRecording::factory()->count(1)->create();

        $recording = ConcertRecording::first();
        $concert = $recording->concert;

        $this
            ->get('intern/downloads')
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

    // TODO: validate functioning auth middleware for these routes

}
