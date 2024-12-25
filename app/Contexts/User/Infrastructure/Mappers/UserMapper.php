<?php

namespace App\Contexts\User\Infrastructure\Mappers;

use App\Contexts\User\Domain\Contracts\UserMapperContract;
use App\Contexts\User\Domain\Entities\UserEntity;
use App\Contexts\User\Infrastructure\Eloquent\UserModel;

class UserMapper implements UserMapperContract
{
    public function entityToModel(UserEntity $userEntity): array
    {
        return [
            'id'       => $userEntity->getId(),
            'name'     => $userEntity->getName(),
            'email'    => $userEntity->getEmail(),
            'password' => $userEntity->getHashedPassword(),
            'role'     => $userEntity->getRole(),
        ];
    }

    public function modelToEntity(UserModel $userModel): UserEntity
    {
        return new UserEntity(
            $userModel->id,
            $userModel->name,
            $userModel->email,
            $userModel->password,
            $userModel->role
        );
    }
}
