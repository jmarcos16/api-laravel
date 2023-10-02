<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required'],
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $token = $request->user()->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Logged in successfully',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }
}
