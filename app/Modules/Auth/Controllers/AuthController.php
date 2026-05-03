<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;

use App\Modules\Auth\Services\AuthService;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Modules\Auth\Requests\ForgotPasswordRequest;
use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\DTOs\RegisterDTO;

class AuthController extends Controller
{
    public function __construct(private AuthService $service) {}

    public function register(RegisterRequest $request)
    {
        $dto = RegisterDTO::fromArray($request->validated());

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