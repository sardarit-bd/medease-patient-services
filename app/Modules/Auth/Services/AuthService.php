<?php

namespace App\Modules\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;
use App\Modules\Auth\DTOs\RegisterDTO;
use App\Modules\Auth\DTOs\LoginDTO;

class AuthService
{
    public function register(RegisterDTO $dto)
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::success([
            'user' => $user,
            'token' => $token
        ], 'User registered successfully');
    }

    public function login(LoginDTO $dto)
    {
        $user = User::where('email', $dto->email)->first();

        if (!$user || !Hash::check($dto->password, $user->password)) {
            return ApiResponse::error('Invalid credentials', 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::success([
            'user' => $user,
            'token' => $token
        ], 'Login successful');
    }

    public function logout($user)
    {
         if (!$user) {
        return ApiResponse::error('Unauthenticated', 401);
    }
        $user->currentAccessToken()->delete();

        return ApiResponse::success(null, 'Logged out successfully');
    }

    public function me($user)
    {

     if (!$user) {
        return ApiResponse::error('Unauthenticated', 401);
    }
        return ApiResponse::success($user, 'User profile');
    }
}