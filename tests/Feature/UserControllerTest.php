<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_users()
    {
        User::factory()->count(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonCount(3, ['*'])
            ->assertJsonStructure([
                '*' => ['id', 'name', 'created_at']
            ]);
    }

    #[Test]
    public function it_can_create_a_user()
    {
        $userData = ['name' => 'Test User'];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
            ->assertJsonFragment($userData);

        $this->assertDatabaseHas('users', $userData);
    }

    #[Test]
    public function it_validates_name_when_creating_user()
    {
        $response = $this->postJson('/api/users', ['name' => '']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    #[Test]
    public function it_can_show_a_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $user->id,
                'name' => $user->name
            ]);
    }

    #[Test]
    public function it_returns_404_for_nonexistent_user()
    {
        $response = $this->getJson('/api/users/999');

        $response->assertStatus(404);
    }

    #[Test]
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();
        $updateData = ['name' => 'Updated Name'];

        $response = $this->putJson("/api/users/{$user->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment($updateData);

        $this->assertDatabaseHas('users', $updateData);
    }

    #[Test]
    public function it_validates_name_when_updating_user()
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", ['name' => '']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    #[Test]
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function it_can_get_user_posts()
    {
        $user = User::factory()
            ->hasPosts(2)
            ->create();

        $response = $this->getJson("/api/users/{$user->id}/posts");

        $response->assertStatus(200)
            ->assertJsonCount(2, '*');
    }

    #[Test]
    public function it_can_get_user_comments()
    {
        $user = User::factory()
            ->hasComments(3)
            ->create();

        $response = $this->getJson("/api/users/{$user->id}/comments");

        $response->assertStatus(200)
            ->assertJsonCount(3, '*');
    }
}
