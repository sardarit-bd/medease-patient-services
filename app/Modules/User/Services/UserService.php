<?php

namespace App\Modules\User\Services;

use App\Models\PatientProfile;
use App\Models\User;
use App\Modules\User\DTOs\UpdateProfileDTO;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;

class UserService
{
    public function getProfile(User $user): ?PatientProfile
    {
        return PatientProfile::where('user_id', $user->id)->first();
    }

    public function updateProfile(User $user, UpdateProfileDTO $dto): PatientProfile
    {
        $profile = PatientProfile::updateOrCreate(
            ['user_id' => $user->id],
            $dto->toArray()
        );

        return $profile->fresh();
    }

    public function uploadPhoto(User $user, UploadedFile $file): PatientProfile
    {
        $profile = PatientProfile::firstOrNew(['user_id' => $user->id]);

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        if ($profile->photo_url) {
            $oldPath = str_replace('/storage/', '', $profile->photo_url);
            $disk->delete($oldPath);
        }

        $path = $file->store("profile-photos/{$user->id}", 'public');

        $profile->photo_url = $disk->url($path);
        $profile->save();

        return $profile->fresh();
    }

    public function softDeleteAccount(User $user): void
    {
        $user->tokens()->delete();
        $user->delete();
    }

    public function hardDeleteAccount(User $user): void
    {
        $user->tokens()->delete();

        $profile = PatientProfile::where('user_id', $user->id)->first();

        if ($profile && $profile->photo_url) {
            $oldPath = str_replace('/storage/', 'public/', $profile->photo_url);
            Storage::delete($oldPath);
        }

        $user->forceDelete();
    }
}
