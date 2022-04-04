<?php

namespace Http\Controllers;

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
