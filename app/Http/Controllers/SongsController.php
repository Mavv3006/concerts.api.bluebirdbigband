<?php

namespace App\Http\Controllers;

use App\Http\Resources\SongResource;
use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Http\ResponseFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SongsController extends Controller
{
    public function getAll(): JsonResponse
    {
        $songs = Song::all();
        return SongResource::collection($songs)->response();
    }

    public function oneFile(Request $request): StreamedResponse|JsonResponse
    {
        $file_name = $request->query('file_name');

        if ($file_name == null) {
            Log::warning("[SongsController] 'file_name' query parameter is not set.");
            return response()->json(['error' => "Required 'file_name' query parameter is set"], 400);
        }

        Log::info("[SongsController] Requesting to download file with name '" . $file_name . "'");
        $file_path = 'songs/' . $file_name;
        if (!Storage::exists($file_path) || $file_name == ".gitkeep") {
            Log::warning("[SongsController] The file does not exist");
            return response()->json(['error' => "File not found"], status: 404);
        }

        Log::info('[SongsController] The file does exist');
        return Storage::download($file_path);

    }
}
