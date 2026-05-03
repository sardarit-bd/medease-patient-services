<?php

namespace App\Modules\Dashboard\Models;

use App\Modules\PatientProfile\Models\PatientProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVital extends Model
{
    use HasUuids;

    protected $table = 'user_vitals';

    protected $fillable = [
        'patient_id',
        'type',
        'value',
        'unit',
        'source',
        'notes',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'value'       => 'float',
            'recorded_at' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}