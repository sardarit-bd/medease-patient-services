<?php

namespace App\Modules\User\Services;

use App\Models\User;
use App\Modules\User\DTOs\CreateUserDTO;
use App\Modules\User\DTOs\UpdateUserDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function findOrFail(int $id): User
    {
        return User::findOrFail($id);
    }

    public function create(CreateUserDTO $dto): User
    {
        return User::create([
            'name'     => $dto->name,
            'email'    => $dto->email,
            'password' => Hash::make($dto->password),
        ]);
    }

    public function update(int $id, UpdateUserDTO $dto): User
    {
        $user = User::findOrFail($id);

        $user->update(array_filter([
            'name'     => $dto->name,
            'email'    => $dto->email,
            'password' => $dto->password ? Hash::make($dto->password) : null,
        ]));

        return $user->fresh();
    }

    public function delete(int $id): void
    {
        User::findOrFail($id)->delete();
    }
}