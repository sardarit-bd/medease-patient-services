<?php

namespace App\Modules\User\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\User\DTOs\UpdateProfileDTO;
use App\Modules\User\Requests\UpdateProfileRequest;
use App\Modules\User\Requests\UploadPhotoRequest;
use App\Modules\User\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $service) {}

    public function getProfile(Request $request)
    {
        $profile = $this->service->getProfile($request->user());

        return ApiResponse::success($profile, 'Profile fetched successfully');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $dto = UpdateProfileDTO::fromArray($request->validated());
        $profile = $this->service->updateProfile($request->user(), $dto);

        return ApiResponse::success($profile, 'Profile updated successfully');
    }

    public function uploadPhoto(UploadPhotoRequest $request)
    {
        $profile = $this->service->uploadPhoto($request->user(), $request->file('photo'));

        return ApiResponse::success($profile, 'Photo uploaded successfully');
    }

    public function softDelete(Request $request)
    {
        $this->service->softDeleteAccount($request->user());

        return ApiResponse::success(null, 'Account deactivated successfully');
    }

    public function hardDelete(Request $request)
    {
        $this->service->hardDeleteAccount($request->user());

        return ApiResponse::success(null, 'Account permanently deleted');
    }
}
