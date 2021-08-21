<?php


namespace App\Http\Controllers;


use App\Http\Resources\ConcertResource;
use App\Models\Concert;
use Illuminate\Support\Carbon;

class ConcertsController extends Controller
{
    public function all()
    {
        return ConcertResource::collection(Concert::with('band', 'place')->get());
    }

    public function upcoming()
    {
        $concerts = Concert::with('band', 'place')
            ->whereDate('date', '>=', Carbon::today()->toDateString())
            ->get();
        return ConcertResource::collection($concerts);
    }

    public function past()
    {
        $concerts = Concert::with('band', 'place')
            ->whereDate('date', '<', Carbon::today()->toDateString())
            ->get();
        return ConcertResource::collection($concerts);
    }
}
