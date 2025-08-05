<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;

/**
 * Контроллер для управления комментариями
 * 
 * Обеспечивает базовые CRUD-операции для комментариев к постам
 */
class CommentController extends Controller
{
    /**
     * Получить список всех комментариев
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * Возвращает коллекцию всех комментариев в формате JSON
     */
    public function index()
    {
        return CommentResource::collection(Comment::all());
    }

    /**
     * Создать новый комментарий
     *
     * @param CommentRequest $request Запрос с валидированными данными
     * @return CommentResource
     * Возвращает созданный комментарий с кодом ответа 201
     * 
     * @throws \Illuminate\Validation\ValidationException
     * Если данные не прошли валидацию
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->validated());
        return new CommentResource($comment);
    }

    /**
     * Получить конкретный комментарий
     *
     * @param Comment $comment Модель комментария (автоматическое разрешение)
     * @return CommentResource
     * Возвращает запрошенный комментарий в формате JSON
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Обновить существующий комментарий
     *
     * @param CommentRequest $request Запрос с валидированными данными
     * @param Comment $comment Модель комментария для обновления
     * @return CommentResource
     * Возвращает обновленный комментарий в формате JSON
     * 
     * @throws \Illuminate\Validation\ValidationException
     * Если данные не прошли валидацию
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());
        return new CommentResource($comment);
    }

    /**
     * Удалить комментарий
     *
     * @param Comment $comment Модель комментария для удаления
     * @return \Illuminate\Http\Response
     * Возвращает пустой ответ с кодом 204 (No Content)
     * 
     * @throws \Exception
     * Если возникла ошибка при удалении
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->noContent();
    }
}
