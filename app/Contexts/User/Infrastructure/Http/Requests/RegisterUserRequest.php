<?php

namespace App\Contexts\User\Infrastructure\Http\Requests;

use App\Contexts\User\Domain\Entities\UserEntity;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'sometimes|in:' . implode(",", UserEntity::ALL_ROLES)
        ];
    }
}
