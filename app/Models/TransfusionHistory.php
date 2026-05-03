<?php

namespace App\Modules\PatientProfile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransfusionHistory extends Model
{
    use HasUuids;

    protected $table = 'transfusion_history';

    protected $fillable = [
        'patient_id',
        'transfusion_date',
        'facility_name',
        'department',
        'units_count',
        'reason',
        'other_reason',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'transfusion_date' => 'date',
            'units_count'      => 'integer',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}