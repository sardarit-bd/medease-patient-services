<?php

namespace App\Modules\User\DTOs;

class CreateUserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {}

    public static function fromRequest(object $data): self
    {
        return new self(
            name: $data->name,
            email: $data->email,
            password: $data->password,
        );
    }
}