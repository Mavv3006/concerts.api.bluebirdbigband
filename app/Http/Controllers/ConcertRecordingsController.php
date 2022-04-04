<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use function response;

class ConcertRecordingsController extends Controller
{
    public function oneFile(Request $request): StreamedResponse|JsonResponse
    {
        try {
            $credentials = $this->validate($request, [
                'file_name' => 'required',
            ]);

            $file_name = $credentials['file_name'];
            Log::info("[ConcertRecordingsController] Requesting to download file with name '" . $file_name . "'");

            $file_path = 'recordings/' . $file_name;
            if (!Storage::exists($file_path) || $file_name == ".gitkeep") {
                Log::warning("[ConcertRecordingsController] The file does not exist");
                return response()->json(['error' => "File not found"], status: 404);
            }

            Log::info('[ConcertRecordingsController] The file does exist');
            return Storage::download($file_path);
        } catch (ValidationException $e) {
            Log::warning("[ConcertRecordingsController] 'file_name' query parameter is not set.");
            return response()->json([
                'error' => "Required 'file_name' query parameter is set",
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
