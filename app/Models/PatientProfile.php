<?php

namespace App\Modules\PatientProfile\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PatientProfile extends Model
{
    use HasUuids;

    protected $table = 'patient_profiles';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'blood_type',
        'height',
        'weight',
        'photo_url',
        'social_security_number',
        'address',
        'city',
        'postal_code',
        'country',
        'phone',
    ];

    protected $hidden = [
        'social_security_number',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'height'        => 'float',
            'weight'        => 'float',
        ];
    }

    // ── Relationships ──────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function medicalDevices(): HasMany
    {
        return $this->hasMany(MedicalDevice::class, 'patient_id');
    }

    public function physicalConditions(): HasMany
    {
        return $this->hasMany(PhysicalCondition::class, 'patient_id');
    }

    public function physicalActivities(): HasMany
    {
        return $this->hasMany(PhysicalActivity::class, 'patient_id');
    }

    public function substanceConsumptions(): HasMany
    {
        return $this->hasMany(SubstanceConsumption::class, 'patient_id');
    }

    public function medicalHistory(): HasMany
    {
        return $this->hasMany(MedicalHistory::class, 'patient_id');
    }

    public function transfusionHistory(): HasMany
    {
        return $this->hasMany(TransfusionHistory::class, 'patient_id');
    }

    public function dentalDevices(): HasMany
    {
        return $this->hasMany(DentalDevice::class, 'patient_id');
    }

    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(EmergencyContact::class, 'patient_id');
    }

    public function vaccinationRecords(): HasMany
    {
        return $this->hasMany(VaccinationRecord::class, 'patient_id');
    }

    public function allergies(): HasMany
    {
        return $this->hasMany(Allergy::class, 'patient_id');
    }

    public function advanceDirective(): HasOne
    {
        return $this->hasOne(AdvanceDirective::class, 'patient_id');
    }
}