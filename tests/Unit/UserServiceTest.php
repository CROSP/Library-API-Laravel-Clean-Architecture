<?php

namespace Tests\Unit;

use App\Contexts\User\Application\UserService;
use App\Contexts\User\Domain\Contracts\UserMapperContract;
use App\Contexts\User\Domain\Contracts\UserRepositoryContract;
use App\Contexts\User\Domain\Entities\UserEntity;
use App\Contexts\User\Domain\Events\UserLoggedInEvent;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserServiceTest extends TestCase
{
    public function test_register_user_with_existing_email()
    {
        $userRepoMock = Mockery::mock(UserRepositoryContract::class);
        $userMapperMock = Mockery::mock(UserMapperContract::class);

        $name = 'Jane Doe';
        $email = 'jane@example.com';
        $plainPassword = 'password456';
        $role = UserEntity::ROLE_MEMBER;

        $hashedPassword = Hash::make($plainPassword);

        $userEntityToCreate = new UserEntity(
            id: null,
            name: $name,
            email: $email,
            hashedPassword: $hashedPassword,
            role: $role
        );

        $userRepoMock->shouldReceive('create')
            ->once()
            ->with(Mockery::any())
            ->andThrow(new \Exception('Email already exists'));

        $userService = new UserService($userRepoMock, $userMapperMock);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Email already exists');

        $userService->registerUser($name, $email, $plainPassword, $role);
    }

    public function test_login_user_with_invalid_credentials()
    {
        $userRepoMock = Mockery::mock(UserRepositoryContract::class);
        $userMapperMock = Mockery::mock(UserMapperContract::class);

        $email = 'nonexistent@example.com';
        $plainPassword = 'wrongpassword';

        $credentials = [
            'email' => $email,
            'password' => $plainPassword,
        ];

        JWTAuth::shouldReceive('attempt')
            ->once()
            ->with($credentials)
            ->andReturn(false);

        $userService = new UserService($userRepoMock, $userMapperMock);

        $resultToken = $userService->loginUser($email, $plainPassword);

        $this->assertNull($resultToken);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
