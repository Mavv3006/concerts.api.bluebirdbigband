<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {

        try {
            $credentials = $this->validate($request, [
                'name' => 'required',
                'password' => 'required'
            ]);

            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Bad Request', 'message', $e->getMessage()], 403);
        }
    }

    public function logout(): JsonResponse
    {
        auth()->logout();
        auth()->invalidate();
        $user = auth()->user();
        Log::info($user);

        return response()->json(['message' => 'Successfully logged out', 'current user' => $user]);
    }

    public function me(): JsonResponse
    {
        $user = auth()->user();
        Log::info($user);
        return response()->json($user);
    }

    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
