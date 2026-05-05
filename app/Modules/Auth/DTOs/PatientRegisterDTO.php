<?php

namespace App\Modules\Auth\DTOs;

class patientRegisterDTO
{
    public function __construct(
        public string $email,
        public string $password,
        public string $role
    ) {}
    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
            role: $data['role'],
        );
    }
}
