<?php

namespace App\Modules\Auth\DTOs;

class RegisterDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}

    public static function fromRequest($request): self // here we are defining a static method called fromRequest  and here with self we are creating an instance of the RegisterDTO class and passing
    {
        return new self(
            $request->name,
            $request->email,
            $request->password
        );
    }
}