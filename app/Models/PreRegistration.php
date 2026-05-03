<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PreRegistration extends Model
{
    use HasUuids;

    protected $table = 'pre_registrations';

    protected $fillable = [
        'email',
        'password',
        'profile_type',
        'verification_code',
        'is_verified',
        'step',
        'expires_at',
    ];

    protected $hidden = [
        'password',
        'verification_code',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'expires_at'  => 'datetime',
            'password'    => 'hashed',
        ];
    }
}