<?php

namespace App\Http\Controllers;

use App\Models\ConcertRecording;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Http\ResponseFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    function getAllFileNames(): JsonResponse
    {
        $all_files = Storage::disk('local')->allFiles();
        $txt_files = array_filter($all_files, fn(string $file) => str_ends_with($file, '.txt'));
        return response()->json($txt_files);
    }

    function download(int $id): Response|StreamedResponse|ResponseFactory
    {
        $filename = "test.txt";
        switch ($id) {
            case 1:
                if (Storage::exists($filename)) {
                    return Storage::download($filename);
                } else {
                    return response("File not found", status: 404);
                }
            case 2:
                return response("File not found", status: 404);
            default:
                return response("File does not exist", status: 404);
        }
    }

    function downloadByName(Request $request): Response|StreamedResponse|ResponseFactory
    {
        $name = $request->query('name');
        Log::info("requesting to download file with name '" . $name . "'");

        if (Storage::exists($name)) {
            Log::info("the file does exist");
            return Storage::download($name);
        }

        Log::warning("the file does not exist");
        return \response("File not found", status: 404);
    }

    function recordings(): JsonResponse
    {
        return response()->json(ConcertRecording::all());
    }
}
