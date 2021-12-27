<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class InternController extends Controller
{
    public function basics(): JsonResponse
    {
        $data = [
            'emails' => [
                'musikerinnen@bluebirdbigband.de'
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
        return response()->json();
    }
}
