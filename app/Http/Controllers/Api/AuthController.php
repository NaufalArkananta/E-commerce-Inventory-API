<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'] ?? 'user',
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'User registered successfully',
            'data' => $user
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Cek apakah email valid
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Email or password is incorrect'
            ], 404);
        }

        // Cek password
        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Email or password is incorrect'
            ], 401);
        }

        // Login & generate token
        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}
