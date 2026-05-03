<?php

namespace App\Modules\PatientProfile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhysicalActivity extends Model
{
    use HasUuids;

    protected $table = 'physical_activities';

    protected $fillable = [
        'patient_id',
        'activity_name',
        'category',
        'other_activity',
        'frequency',
        'avg_duration',
        'intensity',
        'objective',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}