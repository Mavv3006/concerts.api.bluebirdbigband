<?php

namespace App\Http\Controllers;

use App\Http\Resources\SongResource;
use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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
            //  https://code-boxx.com/convert-array-string-php/
            $array = $validator->errors()->messages();
            var_dump(implode(" ", $array));
            return response()->json([
                'error' => "Required 'file_name' query parameter is not set",
                'message' => $validator->errors()->messages()
            ], 400);
        }
        try {

            $credentials = $this->validate($request, [
                'file_name' => [
                    'required',
                    'filled',
                    function ($attribute, $value, $fail) use ($request) {
                        $is_query_param = $request->query('file_name') == $value;
                        if (!$is_query_param) {
                            $fail  ('The ' . $attribute . ' is invalid.');
                        }
                    }
                ],
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
            var_dump("Validator is not running");
            return response()->json([
                'error' => "Required 'file_name' query parameter is not set",
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
