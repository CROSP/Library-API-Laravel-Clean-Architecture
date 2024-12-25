<?php

namespace App\Contexts\User\Infrastructure\Persistence;

use App\Contexts\User\Domain\Contracts\UserRepositoryContract;
use App\Contexts\User\Domain\Entities\UserEntity;
use App\Contexts\User\Infrastructure\Eloquent\UserModel;

class EloquentUserRepository implements UserRepositoryContract
{
    public function create(UserEntity $user): UserModel
    {
        $model = new UserModel();
        $model->name = $user->getName();
        $model->email = $user->getEmail();
        $model->password = $user->getHashedPassword();
        $model->role = $user->getRole();
        $model->save();

        return $model;
    }

    public function findByEmail(string $email): ?UserModel
    {
        $model = UserModel::where('email', $email)->first();
        return $model;
    }

    public function findById(int $id): ?UserModel
    {
        $model = UserModel::find($id);
        return $model;
    }
}
