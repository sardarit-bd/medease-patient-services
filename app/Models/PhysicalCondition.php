<?php

namespace App\Modules\PatientProfile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhysicalCondition extends Model
{
    use HasUuids;

    protected $table = 'physical_conditions';

    protected $fillable = [
        'patient_id',
        'condition_type',
        'condition_name',
        'other_condition',
        'body_location',
        'diagnosis_date',
        'date_range',
        'severity',
        'current_treatment',
    ];

    protected function casts(): array
    {
        return [
            'diagnosis_date'    => 'date',
            'current_treatment' => 'array',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}