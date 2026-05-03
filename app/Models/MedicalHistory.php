<?php

namespace App\Modules\PatientProfile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalHistory extends Model
{
    use HasUuids;

    protected $table = 'medical_history';

    protected $fillable = [
        'patient_id',
        'history_type',
        'category',
        'condition_name',
        'other_condition',
        'event_date',
        'date_range',
        'facility_id',
        'facility_name',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}