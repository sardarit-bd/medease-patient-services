<?php

namespace App\Modules\User\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\User\DTOs\CreateUserDTO;
use App\Modules\User\DTOs\UpdateUserDTO;
use App\Modules\User\Requests\CreateUserRequest;
use App\Modules\User\Requests\UpdateUserRequest;
use App\Modules\User\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function index(): JsonResponse
    {
        $users = $this->userService->getAll();

        return ApiResponse::success($users, 'Users retrieved successfully');
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->userService->findOrFail($id);

        return ApiResponse::success($user, 'User retrieved successfully');
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $dto  = CreateUserDTO::fromRequest((object) $request->validated());
        $user = $this->userService->create($dto);

        return ApiResponse::success($user, 'User created successfully', 201);
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $dto  = UpdateUserDTO::fromRequest((object) $request->validated());
        $user = $this->userService->update($id, $dto);

        return ApiResponse::success($user, 'User updated successfully');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->userService->delete($id);

        return ApiResponse::success(null, 'User deleted successfully');
    }
}