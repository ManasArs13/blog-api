<?php

namespace Tests\Feature\Unit;

use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserRequestTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_request_validation()
    {
        $request = new UserRequest();

        // Проверка обязательного поля name
        $validator = Validator::make(['name' => ''], $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());

        // Проверка успешной валидации
        $validator = Validator::make(['name' => 'Valid Name'], $request->rules());
        $this->assertFalse($validator->fails());
    }
}
