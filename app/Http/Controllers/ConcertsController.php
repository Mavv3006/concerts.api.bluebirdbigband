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
        return ConcertResource::collection($this->upcoming_concerts());
    }

    public function past()
    {
        $concerts = Concert::with('band', 'place')
            ->whereDate('date', '<', Carbon::today()->toDateString())
            ->get();
        return ConcertResource::collection($concerts);
    }

    public function old_upcoming()
    {

    }

    private function upcoming_concerts()
    {
        return Concert::with('band', 'place')
            ->whereDate('date', '>=', Carbon::today()->toDateString())
            ->get();
    }
}
