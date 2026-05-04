<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicationSchedule extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'medication_schedule';

    protected $fillable = [
        'medication_id', 'patient_id',
        'time_of_day', 'moment',
        'quantity', 'unit', 'instruction', 'days',
    ];

    protected $casts = [
        'days'     => 'array',
        'quantity' => 'float',
    ];

    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medication_id');
    }

    public function intakeLogs()
    {
        return $this->hasMany(MedicationIntakeLog::class, 'schedule_id');
    }
}