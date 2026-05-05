<?php

namespace App\Modules\Auth\Services;

use App\Models\User;
use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\DTOs\patientRegisterDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(patientRegisterDTO $dto): array
    {
        $user = User::create([
            'email' => $dto->email,
            'password' => $dto->password,
            'role' => $dto->role,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'role' => $dto->role,
        ];
    }

    public function login(LoginDTO $dto): array
    {
        if (! Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password,
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

    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }

    public function refreshToken(User $user): string
    {

        $user->currentAccessToken()->delete();

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function forgotPassword(string $email): void
    {
        Password::sendResetLink(['email' => $email]);
    }
}
