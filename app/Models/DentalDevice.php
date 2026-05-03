<?php

namespace App\Modules\PatientProfile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DentalDevice extends Model
{
    use HasUuids;

    protected $table = 'dental_devices';

    protected $fillable = [
        'patient_id',
        'device_type',
        'other_device',
        'tooth_type',
        'jaw_position',
        'placement_date',
        'facility_name',
        'dentist_name',
        'documents',
    ];

    protected function casts(): array
    {
        return [
            'placement_date' => 'date',
            'documents'      => 'array',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}