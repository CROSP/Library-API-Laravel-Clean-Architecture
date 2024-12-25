<?php

namespace App\Contexts\User\Domain\Entities;

class UserEntity
{
    const ROLE_MEMBER = "member";
    const ROLE_LIBRARIAN = "librarian";
    const ALL_ROLES = [self::ROLE_LIBRARIAN, self::ROLE_MEMBER];
    private ?int $id;
    private string $name;
    private string $email;
    private string $hashedPassword;
    private string $role;

    public function __construct(
        ?int   $id,
        string $name,
        string $email,
        string $hashedPassword,
        string $role = self::ROLE_MEMBER
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->role = $role;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }


}
