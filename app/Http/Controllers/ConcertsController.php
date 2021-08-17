<?php


namespace App\Http\Controllers;


use App\Models\Concert;

class ConcertsController extends Controller
{
    public function all()
    {
        $date = Concert::all()->first;
        return response([
            'date' => $date->date
        ]);
    }

    public function upcoming()
    {

    }

    public function past()
    {

    }
}
