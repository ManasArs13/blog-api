<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Post;

/**
 * Контроллер для управления постами
 *
 * Предоставляет методы для работы с постами пользователей,
 * включая получение, создание, обновление и удаление постов,
 * а также получение комментариев к постам.
 */
class PostController extends Controller
{
    /**
     * Получить список всех постов
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * Коллекция постов в формате JSON
     */
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Создать новый пост
     *
     * @param PostRequest $request Запрос с валидированными данными
     * @return PostResource Созданный пост
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->validated());
        return new PostResource($post);
    }

    /**
     * Получить конкретный пост
     *
     * @param Post $post Модель поста
     * @return PostResource Запрошенный пост
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Обновить существующий пост
     *
     * @param PostRequest $request Запрос с валидированными данными
     * @param Post $post Модель поста для обновления
     * @return PostResource Обновленный пост
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return new PostResource($post);
    }

    /**
     * Удалить пост
     *
     * @param Post $post Модель поста для удаления
     * @return \Illuminate\Http\Response Ответ с пустым телом и кодом 204
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->noContent();
    }

    /**
     * Получить все комментарии к посту
     *
     * @param Post $post Модель поста
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * Коллекция комментариев к посту в формате JSON
     */
    public function comments(Post $post)
    {
        return CommentResource::collection($post->comments);
    }
}
