<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\CommentController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // //Route::apiResource('users', UserController::class)
    //     ->only(['index', 'show', 'update', 'destroy']);

    // Route::apiResource('posts', PostController::class)
    //     ->except(['index', 'show']);

    Route::prefix('/users')->group(function($route) {
        $route->get('/', [UserController::class, 'index']);
        $route->get('/{user}', [UserController::class, 'show']);
        $route->put('/{user}', [UserController::class, 'update']);
        $route->patch('/{user}', [UserController::class, 'update']);
        $route->delete('/{user}', [UserController::class, 'destroy']);
    });

    Route::prefix('/posts')->group(function($route) {
        $route->get('/', [PostController::class, 'index']);
        $route->post('/', [PostController::class, 'store']);
        $route->get('/{post}', [PostController::class, 'show']);
        $route->put('/{post}', [PostController::class, 'update']);
        $route->patch('/{post}', [PostController::class, 'update']);
        $route->delete('/{post}', [PostController::class, 'destroy']);
    });

    Route::post('/posts/{post}/like', [LikeController::class, 'store']);
    Route::delete('/posts/{post}/like', [LikeController::class, 'destroy']);

    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    Route::put('/comments/{comment}', [CommentController::class, 'update']);
    Route::patch('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
});