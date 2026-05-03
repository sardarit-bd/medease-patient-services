<?php

namespace App\Modules\PatientProfile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VaccinationRecord extends Model
{
    use HasUuids;

    protected $table = 'vaccination_records';

    protected $fillable = [
        'patient_id',
        'vaccine_name',
        'vaccine_category',
        'other_vaccine',
        'dose_type',
        'vaccination_date',
        'professional_name',
        'facility_name',
        'batch_number',
        'documents',
    ];

    protected function casts(): array
    {
        return [
            'vaccination_date' => 'date',
            'documents'        => 'array',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}