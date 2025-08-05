<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::apiResource('users', UserController::class);
Route::apiResource('posts', PostController::class);
Route::apiResource('comments', CommentController::class);

// Специальные маршруты
Route::get('users/{user}/posts', [UserController::class, 'posts']);
Route::get('users/{user}/comments', [UserController::class, 'comments']);
Route::get('posts/{post}/comments', [PostController::class, 'comments']);
