<?php

namespace App\Modules\User\Services;

use App\Models\User;
use App\Models\PatientProfile;
use App\Modules\User\DTOs\UpdateProfileDTO;
use Illuminate\Support\Facades\Storage;

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


    public function uploadPhoto(User $user, $file): PatientProfile
    {
        $profile = PatientProfile::firstOrNew(['user_id' => $user->id]);

    
        if ($profile->photo_url) {
            $oldPath = str_replace('/storage/', 'public/', $profile->photo_url);
            Storage::delete($oldPath);
        }

        $path = $file->store("public/profile-photos/{$user->id}");
        $url  = Storage::url($path);

        $profile->photo_url = $url;
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