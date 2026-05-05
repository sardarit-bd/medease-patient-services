<?php

namespace App\Modules\Auth\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\DTOs\registerDTO;
use App\Modules\Auth\Requests\ForgotPasswordRequest;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Modules\Auth\Requests\ResetPasswordRequest;
use App\Modules\Auth\Requests\VerifyEmailRequest;
use App\Modules\Auth\Requests\VerifyResetCodeRequest;
use App\Modules\Auth\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private AuthService $service) {}

    public function register(registerRequest $request)
    {
        $dto = registerDTO::fromArray($request->validated());
        $data = $this->service->register($dto);
        return ApiResponse::success($data, 'User registered successfully');
    }


    public function login(LoginRequest $request)
    {
        $dto = LoginDTO::fromArray($request->validated());
        $data = $this->service->login($dto);
        return ApiResponse::success($data, 'Login successful');
    }


    public function verifyEmail(VerifyEmailRequest $request)
    {
        $this->service->verifyEmail(
            $request->email,
            $request->code
        );

        return ApiResponse::success([], 'Email verified successfully');
    }



    public function logout(Request $request)
    {
        $this->service->logout($request->user());

        return ApiResponse::success([], 'Logged out successfully');
    }

    public function refreshToken(Request $request)
    {
        $token = $this->service->refreshToken($request->user());

        return ApiResponse::success(['token' => $token], 'Token refreshed');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $this->service->forgotPassword($request->email);

        return ApiResponse::success([], 'Password reset link sent');
    }

    public function verifyResetCode(VerifyResetCodeRequest $request): JsonResponse
    {
        $this->service->verifyResetCode($request->email, $request->code);

        return ApiResponse::success([], 'Reset code verified successfully');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $this->service->resetPassword(
            $request->email,
            $request->code,
            $request->password,
        );

        return ApiResponse::success([], 'Password reset successfully. Please log in again.');
    }
}
