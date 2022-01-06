<?php

namespace App\Http\Controllers;

use App\Http\Resources\TrimmedConcertResource;
use App\Models\Concert;
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
        return TrimmedConcertResource::collection(Concert::has('recordings')->get())->response();
    }
}
