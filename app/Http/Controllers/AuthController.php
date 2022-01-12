<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            if (!$token = Auth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);
        } catch (ValidationException $e) {
            $content = [
                'error' => 'Bad Request',
                'message' => $e->getMessage()
            ];
            return response()->json($content, 400);
        }
    }

    public function logout(): JsonResponse
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me(): JsonResponse
    {
        $user = Auth::user();
        return response()->json($user);
    }

    protected function respondWithToken(string $token): JsonResponse
    {
        $exp_in = Auth::factory()->getTTL() * 60;
        $exp_at = Carbon::now()
            ->addMinutes($exp_in)
            ->timestamp;
        $content = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires' => [
                "in" => $exp_in,
                'at' => $exp_at,
            ]
        ];
        return response()->json($content);
    }
}
