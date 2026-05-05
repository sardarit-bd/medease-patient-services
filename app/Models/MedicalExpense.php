<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalExpense extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'medical_expenses';

    protected $fillable = [
        'patient_id',
        'prescription_id',
        'label',
        'category',
        'amount',
        'reimbursed',
        'remaining_charge',
        'expense_date',
    ];

    protected $casts = [
        'amount' => 'float',
        'reimbursed' => 'float',
        'remaining_charge' => 'float',
        'expense_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }
}
