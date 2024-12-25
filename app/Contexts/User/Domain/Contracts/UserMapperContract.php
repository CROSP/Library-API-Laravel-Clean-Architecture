<?php

namespace App\Contexts\User\Domain\Contracts;

use App\Contexts\User\Domain\Entities\UserEntity;
use App\Contexts\User\Infrastructure\Eloquent\UserModel;

interface UserMapperContract
{
    public function entityToModel(UserEntity $userEntity): array;
    public function modelToEntity(UserModel $userModel): UserEntity;
}
