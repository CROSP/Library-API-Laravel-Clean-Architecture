<?php

namespace App\Contexts\User\Application;

use App\Contexts\User\Domain\Contracts\UserMapperContract;
use App\Contexts\User\Domain\Contracts\UserRepositoryContract;
use App\Contexts\User\Domain\Entities\UserEntity;
use App\Contexts\User\Domain\Events\UserCreatedEvent;
use App\Contexts\User\Domain\Events\UserLoggedInEvent;
use App\Contexts\User\Domain\Events\UserLoggedOutEvent;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    private UserRepositoryContract $userRepo;
    private UserMapperContract $userMapper;

    public function __construct(UserRepositoryContract $userRepo, UserMapperContract $userMapper)
    {
        $this->userRepo = $userRepo;
        $this->userMapper = $userMapper;
    }

    public function registerUser(
        string $name,
        string $email,
        string $plainPassword,
        string $role = UserEntity::ROLE_MEMBER
    ): array
    {
        $hashed = Hash::make($plainPassword);
        $entity = new UserEntity(
            id: null,
            name: $name,
            email: $email,
            hashedPassword: $hashed,
            role: $role
        );
        $createdUser = $this->userRepo->create($entity);
        $token = JWTAuth::fromUser($createdUser);
        $createdUser = $this->userMapper->modelToEntity($createdUser);
        event(new UserCreatedEvent($createdUser));

        return [
            'user' => $createdUser,
            'token' => $token,
        ];
    }

    public function loginUser(string $email, string $plainPassword): ?string
    {
        $credentials = [
            'email' => $email,
            'password' => $plainPassword,
        ];

        if (!$token = JWTAuth::attempt($credentials)) {
            return null;
        }
        event(new UserLoggedInEvent($email, $token));
        return $token;
    }

    public function getProfile(): ?UserEntity
    {
        $authUser = auth()->user();
        if (!$authUser) {
            return null;
        }
        $currentUser = $this->userRepo->findById($authUser->id);
        return $this->userMapper->modelToEntity($currentUser);
    }

    public function logoutUser(): void
    {
        $currentUser = auth()->user();

        if (!empty($currentUser)) {
            $currentUser = $this->userMapper->modelToEntity($currentUser);
            event(new UserLoggedOutEvent($currentUser));
        }
        auth()->logout();
    }
}
