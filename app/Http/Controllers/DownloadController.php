<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    function getAllFileNames(): JsonResponse
    {
        return response()->json(Storage::disk('local')->allFiles());
    }
}
