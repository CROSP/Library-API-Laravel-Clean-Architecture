<?php

namespace Tests\Feature;

use App\Contexts\Book\Infrastructure\Eloquent\BookModel;
use App\Contexts\User\Infrastructure\Eloquent\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_books_without_auth_fails()
    {
        $response = $this->getJson('/api/books');
        $response->assertStatus(401);
    }

    public function test_list_books_as_authenticated_user()
    {
        $user = UserModel::factory()->create();
        $token = $this->authenticate($user);
        BookModel::factory()->count(2)->create();

        $response = $this->getJson('/api/books', [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200);
        $this->assertCount(2, $response->json());
    }
    protected function authenticate(UserModel $user)
    {
        return JWTAuth::fromUser($user);
    }

    public function test_create_book_as_librarian()
    {
        $librarian = UserModel::factory()->create([
            'role' => 'librarian'
        ]);
        $token = $this->authenticate($librarian);

        $payload = [
            'title' => 'New Book',
            'publisher' => 'Test Publisher',
            'author' => 'Test Author',
            'genre' => 'Test Genre',
            'publication_date' => '2024-01-01',
            'pages' => 123,
            'price' => 19.99,
        ];

        $response = $this->postJson('/api/books', $payload, [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', ['title' => 'New Book']);
    }

    public function test_create_book_as_member_fails()
    {
        $member = UserModel::factory()->create([
            'role' => 'member'
        ]);
        $token = $this->authenticate($member);

        $payload = [
            'title' => 'Member Book',
        ];

        $response = $this->postJson('/api/books', $payload, [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(403);
    }
}
