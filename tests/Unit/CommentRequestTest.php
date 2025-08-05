<?php

namespace Tests\Feature\Unit;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CommentRequestTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function comment_request_validation()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $request = new StoreCommentRequest();

        // Проверка обязательных полей
        $validator = Validator::make([
            'post_id' => '',
            'user_id' => '',
            'body' => ''
        ], $request->rules());

        $errors = $validator->errors()->toArray();
        $this->assertArrayHasKey('post_id', $errors);
        $this->assertArrayHasKey('user_id', $errors);
        $this->assertArrayHasKey('body', $errors);

        // Проверка существования поста и пользователя
        $validator = Validator::make([
            'post_id' => 999,
            'user_id' => 999,
            'body' => 'Valid body'
        ], $request->rules());

        $errors = $validator->errors()->toArray();
        $this->assertArrayHasKey('post_id', $errors);
        $this->assertArrayHasKey('user_id', $errors);

        // Проверка успешной валидации
        $validator = Validator::make([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => 'Valid body'
        ], $request->rules());
        $this->assertFalse($validator->fails());
    }
}
