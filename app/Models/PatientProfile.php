<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientProfile extends Model
{
    use HasUuids;

    protected $table = 'patient_profiles';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'blood_type',
        'height',
        'weight',
        'photo_url',
        'social_security_number',
        'address',
        'city',
        'postal_code',
        'country',
        'phone',
    ];

    protected $hidden = [
        'social_security_number',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'height' => 'float',
            'weight' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
