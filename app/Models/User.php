<?php

namespace App\Models;

use App\Models\PatientProfile;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['email', 'password', 'role',  'email_verified_at', 'verification_code', 'verification_code_expires_at', 'deleted_at', "password_reset_code", "password_reset_code_expires_at"])]
#[Hidden(['password', 'remember_token', 'verification_code', 'verification_code_expires_at', 'deleted_at', "password_reset_code", "password_reset_code_expires_at"])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasUuids, Notifiable, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'email',
        'password',
        'role',
        'email_verified_at',
        'verification_code',
        'verification_code_expires_at',
        'password_reset_code',
        'password_reset_code_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_code',
        'verification_code_expires_at',
        'password_reset_code',
        'password_reset_code_expires_at',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function patientProfile(): HasOne
    {
        return $this->hasOne(PatientProfile::class);
    }

    /**
     * Help IDE understand token type
     */
    public function currentAccessToken(): ?\Laravel\Sanctum\PersonalAccessToken
    {
        return $this->accessToken;
    }
}
