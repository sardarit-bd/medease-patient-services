<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MedicationIntakeLog extends Model
{
    use HasUuids;

    protected $table = 'medication_intake_log';

    // No SoftDeletes — intake logs are immutable audit records

    protected $fillable = [
        'schedule_id', 'patient_id',
        'scheduled_at', 'taken_at',
        'status', 'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'taken_at' => 'datetime',
    ];

    public function schedule()
    {
        return $this->belongsTo(MedicationSchedule::class, 'schedule_id');
    }

    public function patient()
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}
