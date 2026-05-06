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
        'nationality',
        'language',
        'phone',
        'email',
        'address',
        'city',
        'postal_code',
        'country',
        'blood_group',
        'height_cm',
        'weight_kg',
        'imc',
        'dob_of_height_and_weight',
        'profile_completed',
        'photo_url',
    ];

    protected $hidden = [
        'social_security_number',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth'            => 'date',
            'dob_of_height_and_weight' => 'date',
            'height_cm'                => 'decimal:2',
            'weight_kg'                => 'decimal:2',
            'imc'                      => 'integer',
            'profile_completed'        => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
