<?php

namespace App\Http\Controllers;

use App\Http\Resources\SongResource;
use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
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
        try {
            $credentials = $this->validate($request, [
                'file_name' => 'required',
            ]);

            $file_name = $credentials['file_name'];
            Log::info("[SongController] Requesting to download file with name '" . $file_name . "'");

            $file_path = 'songs/' . $file_name;
            if (!Storage::exists($file_path) || $file_name == ".gitkeep") {
                Log::warning("[SongController] The file does not exist");
                return response()->json(['error' => "File not found"], status: 404);
            }

            Log::info('[SongController] The file does exist');
            return Storage::download($file_path);
        } catch (ValidationException $e) {
            Log::warning("[SongController] 'file_name' query parameter is not set.");
            return response()->json([
                'error' => "Required 'file_name' query parameter is set",
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
