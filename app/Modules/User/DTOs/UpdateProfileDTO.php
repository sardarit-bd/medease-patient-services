<?php

namespace App\Modules\User\DTOs;

class UpdateProfileDTO
{
    public function __construct(
        public readonly ?string $first_name,
        public readonly ?string $last_name,
        public readonly ?string $date_of_birth,
        public readonly ?string $gender,
        public readonly ?string $blood_type,
        public readonly ?float  $height,
        public readonly ?float  $weight,
        public readonly ?string $social_security_number,
        public readonly ?string $address,
        public readonly ?string $city,
        public readonly ?string $postal_code,
        public readonly ?string $country,
        public readonly ?string $phone,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            first_name:             $data['first_name']             ?? null,
            last_name:              $data['last_name']              ?? null,
            date_of_birth:          $data['date_of_birth']          ?? null,
            gender:                 $data['gender']                 ?? null,
            blood_type:             $data['blood_type']             ?? null,
            height:                 $data['height']                 ?? null,
            weight:                 $data['weight']                 ?? null,
            social_security_number: $data['social_security_number'] ?? null,
            address:                $data['address']                ?? null,
            city:                   $data['city']                   ?? null,
            postal_code:            $data['postal_code']            ?? null,
            country:                $data['country']                ?? null,
            phone:                  $data['phone']                  ?? null,
        );
    }


    public function toArray(): array
    {
        return array_filter([
            'first_name'             => $this->first_name,
            'last_name'              => $this->last_name,
            'date_of_birth'          => $this->date_of_birth,
            'gender'                 => $this->gender,
            'blood_type'             => $this->blood_type,
            'height'                 => $this->height,
            'weight'                 => $this->weight,
            'social_security_number' => $this->social_security_number,
            'address'                => $this->address,
            'city'                   => $this->city,
            'postal_code'            => $this->postal_code,
            'country'                => $this->country,
            'phone'                  => $this->phone,
        ], fn($value) => !is_null($value));
    }
}