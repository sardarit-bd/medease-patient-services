<?php

namespace App\Modules\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use App\Modules\Auth\DTOs\RegisterDTO;
use App\Modules\Auth\DTOs\LoginDTO;

class AuthService
{
    public function register(RegisterDTO $dto): array
    {
      $user = User::create([
    'email' => $dto->email,
    'password' => $dto->password,
    'role' => 'patient',
]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(LoginDTO $dto): array
    {
        if (!Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password
        ])) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        $user = Auth::user();

  
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout($user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function refreshToken($user): string
    {
   
        $user->currentAccessToken()->delete();

  
        return $user->createToken('auth_token')->plainTextToken;
    }

    public function forgotPassword(string $email): void
    {
        Password::sendResetLink(['email' => $email]);
    }
}