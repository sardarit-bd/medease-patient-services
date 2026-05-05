<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medication extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'patient_id', 'prescription_id', 'prescribed_by',
        'name', 'dci', 'form', 'dosage',
        'start_date', 'end_date', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }

    public function schedules()
    {
        return $this->hasMany(MedicationSchedule::class, 'medication_id');
    }

    public function stock()
    {
        return $this->hasOne(MedicationStock::class, 'medication_id');
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }
}
