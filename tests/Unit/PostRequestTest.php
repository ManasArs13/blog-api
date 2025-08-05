<?php

namespace Tests\Feature\Unit;

use App\Http\Requests\Post\StorePostRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostRequestTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function post_request_validation()
    {
        $user = User::factory()->create();
        $request = new StorePostRequest();

        // Проверка обязательных полей
        $validator = Validator::make([
            'user_id' => '',
            'body' => ''
        ], $request->rules());

        $errors = $validator->errors()->toArray();
        $this->assertArrayHasKey('user_id', $errors);
        $this->assertArrayHasKey('body', $errors);

        // Проверка существования пользователя
        $validator = Validator::make([
            'user_id' => 999,
            'body' => 'Valid body'
        ], $request->rules());
        $this->assertArrayHasKey('user_id', $validator->errors()->toArray());

        // Проверка успешной валидации
        $validator = Validator::make([
            'user_id' => $user->id,
            'body' => 'Valid body'
        ], $request->rules());
        $this->assertFalse($validator->fails());
    }
}
