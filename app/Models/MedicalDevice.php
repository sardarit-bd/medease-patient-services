<?php

namespace App\Modules\PatientProfile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalDevice extends Model
{
    use HasUuids;

    protected $table = 'medical_devices';

    protected $fillable = [
        'patient_id',
        'device_type',
        'device_name',
        'other_device',
        'body_location',
        'implant_date',
        'date_range',
        'facility_id',
        'follow_up',
        'documents',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'implant_date' => 'date',
            'documents'    => 'array',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}