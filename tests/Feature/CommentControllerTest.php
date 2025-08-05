<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_comments()
    {
        Comment::factory()->count(4)->create();

        $response = $this->getJson('/api/comments');

        $response->assertStatus(200)
            ->assertJsonCount(4, '*');
    }

    #[Test]
    public function it_can_create_a_comment()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();
        
        $commentData = [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => 'Test comment'
        ];

        $response = $this->postJson('/api/comments', $commentData);

        $response->assertStatus(201)
            ->assertJsonFragment($commentData);
    }

    #[Test]
    public function it_validates_comment_creation()
    {
        $response = $this->postJson('/api/comments', [
            'post_id' => 999,
            'user_id' => 999,
            'body' => ''
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['post_id', 'user_id', 'body']);
    }

    #[Test]
    public function it_can_show_a_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->getJson("/api/comments/{$comment->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $comment->id]);
    }

    #[Test]
    public function it_can_update_a_comment()
    {
        $comment = Comment::factory()->create();
        $updateData = ['body' => 'Updated comment'];

        $response = $this->putJson("/api/comments/{$comment->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment($updateData);
    }

    #[Test]
    public function it_can_delete_a_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->deleteJson("/api/comments/{$comment->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
