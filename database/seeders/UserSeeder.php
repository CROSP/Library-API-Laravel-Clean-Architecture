<?php

namespace Database\Seeders;

use App\Contexts\User\Domain\Entities\UserEntity;
use App\Contexts\User\Infrastructure\Eloquent\UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Librarian
        UserModel::create([
            'name' => 'Alice Librarian',
            'email' => 'librarian@example.com',
            'password' => Hash::make('helloworld1111'),
            'role' => UserEntity::ROLE_LIBRARIAN
        ]);

        // Normal member
        UserModel::create([
            'name' => 'Bob Member',
            'email' => 'member@example.com',
            'password' => Hash::make('helloworld2222'),
            'role' => UserEntity::ROLE_MEMBER
        ]);
    }
}
