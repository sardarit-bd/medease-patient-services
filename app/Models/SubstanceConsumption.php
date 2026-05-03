<?php

namespace App\Modules\PatientProfile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubstanceConsumption extends Model
{
    use HasUuids;

    protected $table = 'substance_consumption';

    protected $fillable = [
        'patient_id',
        'substance_name',
        'other_substance',
        'frequency',
        'mode',
        'last_consumption',
        'context',
    ];

    protected function casts(): array
    {
        return [
            'last_consumption' => 'date',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}