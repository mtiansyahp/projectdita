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

        //validate untuk dia mengecek ini sesuai format ga?

        // ini untuk mencoba cek apakah benar password dan emailnya
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401); // jika gagal maka return satu fungsi ini
        }

        $user  = Auth::user();

        // create a personal access token (Sanctum)
        // untuk membuat token expired 
        $token = $user->createToken('api-token')->plainTextToken;
        // no need for makeHidden() since $hidden is defined
        return response()->json([
            'message' => 'Login successful',
            'data'    => [
                'user' => $user,
                'token' => $token,
                'role' => $user->role // Tambahkan ini
            ],
        ], 200);// jika berhasil mengembalikan return atau kembalian tulisan login sucess dan masukin data ke local storage di (aplication inspect element )data berisi, data user, data token dan role
    }
}
