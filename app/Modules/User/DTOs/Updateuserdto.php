<?php

namespace App\Modules\User\DTOs;

class UpdateUserDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly ?string $password,
    ) {}

    public static function fromRequest(object $data): self
    {
        return new self(
            name: $data->name ?? null,
            email: $data->email ?? null,
            password: $data->password ?? null,
        );
    }
}