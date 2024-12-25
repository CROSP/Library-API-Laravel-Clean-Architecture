<?php

namespace App\Contexts\User\Infrastructure\Eloquent;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];
    /**
     * Define the factory for the model.
     *
     * @return \Database\Factories\UserFactory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role,
        ];
    }
}
