<?php

namespace App\Http\Controllers;

use App\Http\Resources\SongResource;
use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            'file_name' => [
                'required',
                'filled',
                function ($attribute, $value, $fail) use ($request) {
                    $is_query_param = $request->query('file_name') == $value;
                    if (!$is_query_param) {
                        $fail  ('The ' . $attribute . ' is invalid.');
                    }
                }
            ]
        ]);

        if ($validator->fails()) {
            Log::warning("[SongController] 'file_name' query parameter is not set.");
            $mapping_fnc = fn($elem) => $elem[0];
            $message = implode(' ', array_map($mapping_fnc, $validator->errors()->messages()));
            return response()->json([
                'error' => "Required 'file_name' query parameter is not set",
                'message' => $message
            ], 400);
        }

        $file_name = $validator->safe()->only(['file_name'])['file_name'];
        Log::info("[SongController] Requesting to download file with name '" . $file_name . "'");

        $file_path = 'songs/' . $file_name;
        if (!Storage::exists($file_path) || $file_name == ".gitkeep") {
            Log::warning("[SongController] The file does not exist");
            return response()->json(['error' => "File not found"], status: 404);
        }

        Log::info('[SongController] The file does exist');
        return Storage::download($file_path);
    }
}
