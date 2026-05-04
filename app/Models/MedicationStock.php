<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicationStock extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'medication_stock';

    protected $fillable = [
        'medication_id', 'patient_id',
        'current_quantity', 'unit',
        'expiry_date', 'low_stock_threshold', 'last_updated',
    ];

    protected $casts = [
        'current_quantity'    => 'float',
        'low_stock_threshold' => 'integer',
        'expiry_date'         => 'date',
        'last_updated'        => 'datetime',
    ];

    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medication_id');
    }

    public function isLowStock(): bool
    {
        return $this->current_quantity < $this->low_stock_threshold;
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }
}