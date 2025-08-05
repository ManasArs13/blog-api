<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_posts()
    {
        Post::factory()->count(5)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
            ->assertJsonCount(5, '*');
    }

    #[Test]
    public function it_can_create_a_post()
    {
        $user = User::factory()->create();
        $postData = [
            'user_id' => $user->id,
            'body' => 'Test post content'
        ];

        $response = $this->postJson('/api/posts', $postData);

        $response->assertStatus(201)
            ->assertJsonFragment($postData);
    }

    #[Test]
    public function it_validates_post_creation()
    {
        $response = $this->postJson('/api/posts', [
            'user_id' => 999, // Несуществующий пользователь
            'body' => ''
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['user_id', 'body']);
    }

    #[Test]
    public function it_can_show_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $post->id]);
    }

    #[Test]
    public function it_can_update_a_post()
    {
        $post = Post::factory()->create();
        $updateData = ['body' => 'Updated content'];

        $response = $this->putJson("/api/posts/{$post->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment($updateData);
    }

    #[Test]
    public function it_can_delete_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    #[Test]
    public function it_can_get_post_comments()
    {
        $post = Post::factory()
            ->hasComments(3)
            ->create();

        $response = $this->getJson("/api/posts/{$post->id}/comments");

        $response->assertStatus(200)
            ->assertJsonCount(3, '*');
    }
}
