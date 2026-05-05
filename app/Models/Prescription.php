<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'prescribed_by',
        'issued_date',
        'renewal_date',
        'is_active',
        'document_url',
        'notes',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'renewal_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }

    public function prescribedBy()
    {
        return $this->belongsTo(User::class, 'prescribed_by');
    }

    public function medications()
    {
        return $this->hasMany(Medication::class, 'prescription_id');
    }

    public function expenses()
    {
        return $this->hasMany(MedicalExpense::class, 'prescription_id');
    }
}
