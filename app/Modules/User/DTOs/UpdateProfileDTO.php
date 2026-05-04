<?php

namespace App\Modules\User\DTOs;

class UpdateProfileDTO
{
    public function __construct(
        public ?string $first_name    = null,
        public ?string $last_name     = null,
        public ?string $date_of_birth = null,
        public ?string $gender        = null,
        public ?string $blood_type    = null,
        public ?float  $height        = null,
        public ?float  $weight        = null,
        public ?string $address       = null,
        public ?string $city          = null,
        public ?string $postal_code   = null,
        public ?string $country       = null,
        public ?string $phone         = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            first_name:    $data['first_name']    ?? null,
            last_name:     $data['last_name']     ?? null,
            date_of_birth: $data['date_of_birth'] ?? null,
            gender:        $data['gender']        ?? null,
            blood_type:    $data['blood_type']    ?? null,
            height:        isset($data['height']) ? (float) $data['height'] : null,
            weight:        isset($data['weight']) ? (float) $data['weight'] : null,
            address:       $data['address']       ?? null,
            city:          $data['city']          ?? null,
            postal_code:   $data['postal_code']   ?? null,
            country:       $data['country']       ?? null,
            phone:         $data['phone']         ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'date_of_birth' => $this->date_of_birth,
            'gender'        => $this->gender,
            'blood_type'    => $this->blood_type,
            'height'        => $this->height,
            'weight'        => $this->weight,
            'address'       => $this->address,
            'city'          => $this->city,
            'postal_code'   => $this->postal_code,
            'country'       => $this->country,
            'phone'         => $this->phone,
        ], fn($value) => !is_null($value));
    }
}