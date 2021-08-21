<?php


namespace App\Http\Controllers;


use App\Http\Resources\ConcertResource;
use App\Http\Resources\OldConcertResource;
use App\Models\Concert;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class ConcertsController extends Controller
{
    public function all(): JsonResponse
    {
        return (ConcertResource::collection(Concert::with('band', 'place')->get()))
            ->response()
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function upcoming(): JsonResponse
    {
        return (ConcertResource::collection($this->upcoming_concerts()))
            ->response()
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function past(): JsonResponse
    {
        $concerts = Concert::with('band', 'place')
            ->whereDate('date', '<', Carbon::today()->toDateString())
            ->get();
        return (ConcertResource::collection($concerts))
            ->response()
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function old_upcoming(): JsonResponse
    {
        return (OldConcertResource::collection($this->upcoming_concerts()))
            ->response()
            ->header('Access-Control-Allow-Origin', '*');
    }

    private function upcoming_concerts()
    {
        return Concert::with('band', 'place')
            ->whereDate('date', '>=', Carbon::today()->toDateString())
            ->get();
    }
}
