<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * POST /api/login
     * 
     * Request JSON:
     * {
     *   "email": "admin@demo.com",
     *   "password": "admin123"
     * }
     * 
     * Response (200):
     * {
     *   "message": "Login successful",
     *   "data": {
     *     "user": { ... semua atribut kecuali password ... },
     *     "token": "plain-text-token"
     *   }
     * }
     * 
     * Response (401):
     * {
     *   "message": "Invalid credentials"
     * }
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt authentication
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user  = Auth::user();

        // create a personal access token (Sanctum)
        $token = $user->createToken('api-token')->plainTextToken;
        // no need for makeHidden() since $hidden is defined
        return response()->json([
            'message' => 'Login successful',
            'data'    => [
                'user' => $user,
                'token' => $token,
                'role' => $user->role // Tambahkan ini
            ],
        ], 200);
    }
}
