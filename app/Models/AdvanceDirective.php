<?php

namespace App\Modules\PatientProfile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvanceDirective extends Model
{
    use HasUuids;

    protected $table = 'advance_directives';

    protected $fillable = [
        'patient_id',
        'status',
        'resuscitation',
        'ventilation',
        'dialysis',
        'artificial_nutrition',
        'artificial_hydration',
        'limit_treatments',
        'document_url',
    ];

    protected function casts(): array
    {
        return [
            'limit_treatments' => 'boolean',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }
}