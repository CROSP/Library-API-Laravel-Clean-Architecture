<?php

namespace App\Contexts\User\Domain\Contracts;


use App\Contexts\User\Domain\Entities\UserEntity;
use App\Contexts\User\Infrastructure\Eloquent\UserModel;

interface UserRepositoryContract
{
    public function create(UserEntity $user): UserModel;

    public function findByEmail(string $email): ?UserModel;

    public function findById(int $id): ?UserModel;

    // Optionally update, delete, etc. if needed
}
