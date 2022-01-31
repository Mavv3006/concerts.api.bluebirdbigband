<?php

namespace App\Http\Controllers;

use App\Http\Resources\TrimmedConcertResource;
use App\Models\Concert;
use Illuminate\Http\JsonResponse;

class InternController extends Controller
{
    public function basics(): JsonResponse
    {
//        $data = [
//            'emails' => [
//                'all' => 'musikerinnen@bluebirdbigband.de',
//                'maxi' => [
//                    'all' => 'maxi@bluebirdbigband.de',
//                    'trumpet' => 'maxi-Trompeten@bluebirdbigband.de',
//                    'trombone' => 'maxi-Posaunen@bluebirdbigband.de',
//                    'saxophone' => 'maxi-Saxophone@bluebirdbigband.de',
//                    'rhythm' => 'maxi-Rhytmusgruppe@bluebirdbigband.de',
//                ],
//                'midi' => [
//                    'all' => 'midi@bluebirdbigband.de',
//                    'trumpet' => 'midi-Trompeten@bluebirdbigband.de',
//                    'trombone' => 'midi-Posaunen@bluebirdbigband.de',
//                    'saxophone' => 'midi-Saxophone@bluebirdbigband.de',
//                    'rhythm' => 'midi-Rhytmusgruppe@bluebirdbigband.de',
//                ],
//                'other' => [
//                    'bandleader' => 'bandleiter@bluebirdbigband.de',
//                    'webadmin' => 'webadmin@bluebirdbigband.de'
//                ]
//            ],
//            'gigs' => [
//                'bbbb' => 'https://www.google.com',
//                'dtb' => 'https://www.google.com'
//            ]
//        ];
        $data = [
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
        return response()->json($data);
    }

    public function downloads(): JsonResponse
    {
        $concerts = Concert::has('recordings')->get();
        return TrimmedConcertResource::collection($concerts)->response();
    }
}
