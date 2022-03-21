<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Http\ResponseFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;
use function response;

class ConcertRecordingsController extends Controller
{
    public function oneFile(Request $request): Response|StreamedResponse|ResponseFactory
    {
        $file_name = $request->query('file_name');
        Log::info("[ConcertRecordingsController] Requesting to download file with name '" . $file_name . "'");

        $file_path = 'recordings/' . $file_name;
        if (Storage::exists($file_path)) {
            Log::info('[ConcertRecordingsController] The file does exist');
            return Storage::download($file_path);
        }

        Log::warning("[ConcertRecordingsController] The file does not exist");
        return response("File not found", status: 404);
    }
}
