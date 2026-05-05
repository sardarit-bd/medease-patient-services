<?php

namespace App\Modules\Auth\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\DTOs\patientRegisterDTO;
use App\Modules\Auth\Requests\ForgotPasswordRequest;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Requests\patientRegisterRequest;
use App\Modules\Auth\Services\AuthService;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function __construct(private AuthService $service) {}

    public function patient_register(patientRegisterRequest $request)
    {
        $dto = patientRegisterDTO::fromArray($request->validated());

        $data = $this->service->register($dto);

        return ApiResponse::success($data, 'User registered successfully');
    }

    public function professional_register(patientRegisterRequest $request)
    {
        $dto = patientRegisterDTO::fromArray($request->validated());

        $data = $this->service->register($dto);

        return ApiResponse::success($data, 'User registered successfully');
    }

    public function login(LoginRequest $request)
    {
        $dto = LoginDTO::fromArray($request->validated());

        $data = $this->service->login($dto);

        return ApiResponse::success($data, 'Login successful');
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
}
