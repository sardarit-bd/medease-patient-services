<?php

namespace App\Modules\PatientProfile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Allergy extends Model
{
    use HasUuids;

    protected $table = 'allergies';

    protected $fillable = [
        'patient_id',
        'allergy_type',
        'substance_name',
        'other_substance',
        'reaction_types',
        'severity',
        'reaction_date',
        'is_confirmed',
        'emergency_treatment',
    ];

    protected function casts(): array
    {
        return [
            'reaction_date'       => 'date',
            'reaction_types'      => 'array',
            'emergency_treatment' => 'array',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}