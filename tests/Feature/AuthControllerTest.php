<?php

namespace Tests\Feature;

use App\Contexts\User\Infrastructure\Eloquent\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_user()
    {
        $payload = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret123',
            'role' => 'librarian',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure(['user', 'token']);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role'  => 'librarian',
        ]);
    }

    public function test_login_user()
    {
        // Create a user in the database
        $user = UserModel::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $payload = [
            'email'    => 'login@example.com',
            'password' => 'secret123',
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }
}
