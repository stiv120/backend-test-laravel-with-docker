<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(AuthRequest $request)
    {
        $user = User::create(
                [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]
        );
        if (!$user) {
            throw new Exception('Failed to create the user in the database.');
        }
        return response()->json(['message' => 'User created successfully.'], 201);
    }

    public function login(LoginRequest $request)
    {
        $user = User::firstWhere('email', $request->input('email'));
        if (!$user || !Hash::check($request->input('password'), $user?->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = JWTAuth::fromUser($user);
        return response()->json(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => [
                    'id' => $user?->id,
                    'name' => $user?->name,
                    'email' => $user?->email
                ]
            ]
        );
    }
}
