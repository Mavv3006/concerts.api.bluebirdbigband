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
