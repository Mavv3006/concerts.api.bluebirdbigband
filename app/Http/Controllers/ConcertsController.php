<?php


namespace App\Http\Controllers;


use App\Http\Resources\ConcertResource;
use App\Models\Concert;

class ConcertsController extends Controller
{
    public function all()
    {
        return ConcertResource::collection(Concert::with('band', 'place')->get());
    }

    public function upcoming()
    {

    }

    public function past()
    {

    }
}
