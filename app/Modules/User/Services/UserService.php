<?php

namespace App\Modules\User\Services;

use App\Models\User;
use App\Modules\PatientProfile;
use App\Modules\User\DTOs\UpdateProfileDTO;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function getProfile(User $user): PatientProfile
    {
        return PatientProfile::firstOrCreate(
            ['user_id' => $user->id]
        );
    }

    public function updateProfile(User $user, UpdateProfileDTO $dto): PatientProfile
    {
        $profile = PatientProfile::firstOrCreate(
            ['user_id' => $user->id]
        );

        $profile->update($dto->toArray());

        return $profile->fresh();
    }

    public function uploadPhoto(User $user, $file): PatientProfile
    {
        $profile = PatientProfile::firstOrCreate(
            ['user_id' => $user->id]
        );

        // Delete old photo if exists
        if ($profile->photo_url) {
            $oldPath = str_replace('/storage/', 'public/', $profile->photo_url);
            Storage::delete($oldPath);
        }

        $path = $file->store("public/profile-photos/{$user->id}");
        $url  = Storage::url($path);

        $profile->update(['photo_url' => $url]);

        return $profile->fresh();
    }

    public function softDeleteAccount(User $user): void
    {
        $user->tokens()->delete();
        $user->delete(); // soft delete because SoftDeletes trait is used
    }

    public function hardDeleteAccount(User $user): void
    {
        $user->tokens()->delete();

        $profile = $user->patientProfile;

        if ($profile && $profile->photo_url) {
            $oldPath = str_replace('/storage/', 'public/', $profile->photo_url);
            Storage::delete($oldPath);
        }

        $user->forceDelete();
    }
}