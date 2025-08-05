<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\User;

/**
 * Контроллер для управления пользователями
 * 
 * Обеспечивает CRUD-операции для пользователей, а также получение связанных постов и комментариев
 */
class UserController extends Controller
{
    /**
     * Получить список всех пользователей
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Создать нового пользователя
     *
     * @param UserRequest $request Входные данные (требуется name)
     * @return UserResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        return new UserResource($user);
    }

    /**
     * Получить данные конкретного пользователя
     *
     * @param User $user Модель пользователя (автоматическое разрешение зависимостей)
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Обновить данные пользователя
     *
     * @param UserRequest $request Входные данные (требуется name)
     * @param User $user Модель пользователя для обновления
     * @return UserResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        return new UserResource($user);
    }

    /**
     * Удалить пользователя
     *
     * @param User $user Модель пользователя для удаления
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }

    /**
     * Получить все посты пользователя
     *
     * @param User $user Модель пользователя
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function posts(User $user)
    {
        return PostResource::collection($user->posts);
    }

    /**
     * Получить все комментарии пользователя
     *
     * @param User $user Модель пользователя
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function comments(User $user)
    {
        return CommentResource::collection($user->comments);
    }
}
