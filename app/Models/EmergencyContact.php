<?php

namespace App\Modules\PatientProfile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmergencyContact extends Model
{
    use HasUuids;

    protected $table = 'emergency_contacts';

    protected $fillable = [
        'patient_id',
        'full_name',
        'phone',
        'email',
        'relationship',
        'can_decide',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'can_decide' => 'boolean',
            'is_primary' => 'boolean',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}