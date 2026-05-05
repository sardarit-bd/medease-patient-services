<?php

namespace App\Modules\Auth\Services;

use App\Models\User;
use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\DTOs\registerDTO;
use Illuminate\Support\Facades\Auth;
use App\Mail\PasswordResetCodeMail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(registerDTO $dto): array
    {
        $verificationCode = null;
        $expiresAt = null;
        if ($dto->role !== 'patient') {
            $verificationCode = rand(100000, 999999);
            $expiresAt = Carbon::now()->addMinutes(10);
        }

        $user = User::create([
            'email' => $dto->email,
            'password' => $dto->password,
            'role' => $dto->role,
            'verification_code' => $verificationCode,
            'verification_code_expires_at' => $expiresAt,
        ]);


        if ($dto->role !== 'patient') {
            Mail::to($user->email)->send(
                new \App\Mail\VerificationCodeMail($verificationCode)
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'requires_verification' => $dto->role !== 'patient',
        ];
    }



    public function verifyEmail(string $email, string $code): void
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['User not found']
            ]);
        }
        if (
            !$user->verification_code_expires_at ||
            now()->gt($user->verification_code_expires_at)
        ) {
            throw ValidationException::withMessages([
                'code' => ['Verification code expired']
            ]);
        }
        if ($user->verification_code !== $code) {
            throw ValidationException::withMessages([
                'code' => ['Invalid verification code']
            ]);
        }
        $user->update([
            'email_verified_at' => now(),
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ]);
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
        $user = User::where('email', $email)->firstOrFail();

        $code      = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10);

        $user->update([
            'password_reset_code'            => $code,
            'password_reset_code_expires_at' => $expiresAt,
        ]);

        Mail::to($user->email)->send(new PasswordResetCodeMail($code));
    }


    public function resetPassword(string $email, string $code, string $password): void
    {
        $user = User::where('email', $email)->firstOrFail();

        $this->validateResetCode($user, $code);

        $user->update([
            'password'                       => Hash::make($password),
            'password_reset_code'            => null,
            'password_reset_code_expires_at' => null,
        ]);
        $user->tokens()->delete();
    }

    private function validateResetCode(User $user, string $code): void
    {
        if (
            ! $user->password_reset_code_expires_at ||
            now()->gt($user->password_reset_code_expires_at)
        ) {
            throw ValidationException::withMessages([
                'code' => ['Reset code has expired.'],
            ]);
        }

        if ((string) $user->password_reset_code !== $code) {
            throw ValidationException::withMessages([
                'code' => ['Invalid reset code.'],
            ]);
        }
    }



    public function verifyResetCode(string $email, string $code): void
    {
        $user = User::where('email', $email)->firstOrFail();

        $this->validateResetCode($user, $code);
    }
}
