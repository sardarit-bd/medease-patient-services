<?php

namespace App\Modules\User\DTOs;

class UpdateProfileDTO
{
    public function __construct(

        public readonly ?string $first_name,
        public readonly ?string $last_name,
        public readonly ?string $date_of_birth,
        public readonly ?string $gender,
        public readonly ?string $nationality,
        public readonly ?string $language,
        public readonly ?string $phone,
        public readonly ?string $email,
        public readonly ?string $address,
        public readonly ?string $city,
        public readonly ?string $postal_code,
        public readonly ?string $country,
        public readonly ?string $blood_type,
        public readonly ?string $blood_group,
        public readonly ?float  $height_cm,
        public readonly ?float  $weight_kg,
        public readonly ?int    $imc,
        public readonly ?string $dob_of_height_and_weight,
        public readonly ?bool   $profile_completed,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(

            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null,
            date_of_birth: $data['date_of_birth'] ?? null,
            gender: $data['gender'] ?? null,
            nationality: $data['nationality'] ?? null,
            language: $data['language'] ?? null,
            phone: $data['phone'] ?? null,
            email: $data['email'] ?? null,
            address: $data['address'] ?? null,
            city: $data['city'] ?? null,
            postal_code: $data['postal_code'] ?? null,
            country: $data['country'] ?? null,
            blood_type: $data['blood_type'] ?? null,
            blood_group: $data['blood_group'] ?? null,
            height_cm: isset($data['height_cm']) ? (float) $data['height_cm'] : null,
            weight_kg: isset($data['weight_kg']) ? (float) $data['weight_kg'] : null,
            imc: isset($data['imc']) ? (int) $data['imc'] : null,
            dob_of_height_and_weight: $data['dob_of_height_and_weight'] ?? null,
            profile_completed: isset($data['profile_completed']) ? (bool) $data['profile_completed'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'first_name'               => $this->first_name,
            'last_name'                => $this->last_name,
            'date_of_birth'            => $this->date_of_birth,
            'gender'                   => $this->gender,
            'nationality'              => $this->nationality,
            'language'                 => $this->language,
            'phone'                    => $this->phone,
            'email'                    => $this->email,
            'address'                  => $this->address,
            'city'                     => $this->city,
            'postal_code'              => $this->postal_code,
            'country'                  => $this->country,
            'blood_type'               => $this->blood_type,
            'blood_group'              => $this->blood_group,
            'height_cm'                => $this->height_cm,
            'weight_kg'                => $this->weight_kg,
            'imc'                      => $this->imc,
            'dob_of_height_and_weight' => $this->dob_of_height_and_weight,
            'profile_completed'        => $this->profile_completed,
        ], fn($value) => !is_null($value));
    }
}
