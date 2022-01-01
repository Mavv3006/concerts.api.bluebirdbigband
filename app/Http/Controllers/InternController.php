<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Models\ConcertRecording;
use Illuminate\Http\JsonResponse;

class InternController extends Controller
{
    public function basics(): JsonResponse
    {
        $data = [
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
        return response()->json($data);
    }

    public function downloads(): JsonResponse
    {
        $concerts = Concert
            ::with('recordings')
            ->select('date', 'place_description', 'song_name', 'file_name')
            ->get();
        /*
         * - Konzert 1 { place_description: string, date: string }
         *      - Datei 2 { name: string, link: string, datei_name: string, datei_größe: double (in MB) }
         *      - Datei 3 { name: string, link: string, datei_name: string, datei_größe: double (in MB) }
         *      - Datei 4 { name: string, link: string, datei_name: string, datei_größe: double (in MB) }
         *      - Datei 1 { name: string, link: string, datei_name: string, datei_größe: double (in MB) }
         * - Konzert 2 { place_description: string, date: string }
         *      - Datei 1 { name: string, link: string, datei_name: string, datei_größe: double (in MB) }
         *      - Datei 2 { name: string, link: string, datei_name: string, datei_größe: double (in MB) }
         *      - Datei 3 { name: string, link: string, datei_name: string, datei_größe: double (in MB) }
         *      - Datei 4 { name: string, link: string, datei_name: string, datei_größe: double (in MB) }
         * */
        return response()->json($concerts);
    }
}
