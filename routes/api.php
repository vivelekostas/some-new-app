<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\PasswordController;
use App\Http\Controllers\Api\V1\Content\CategoryController;
use App\Http\Controllers\Api\V1\Content\CommentController;
use App\Http\Controllers\Api\V1\Content\LikeController;
use App\Http\Controllers\Api\V1\Content\PostController;
use App\Http\Controllers\Api\V1\Content\TagController;
use App\Http\Controllers\Api\V1\Dashboard\DashboardController;
use App\Http\Controllers\Api\V1\Public\HomeController;
use App\Http\Controllers\Api\V1\TestController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */
    // REGISTRATION PASSWORD
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');
    Route::get('/me', [AuthController::class, 'me'])
        ->middleware('auth:sanctum');
    // Password reset (guest)
    Route::post('/password/forgot', [PasswordController::class, 'forgot']);
    Route::post('/password/reset', [PasswordController::class, 'reset']);
    // Password update (auth user)
    Route::post('/password/update', [PasswordController::class, 'update'])
        ->middleware('auth:sanctum');

    /*
    |--------------------------------------------------------------------------
    | Public. Главная страница.
    |--------------------------------------------------------------------------
    */
    Route::get('/home', HomeController::class);

    /*
    |--------------------------------------------------------------------------
    | Authenticated content
    |--------------------------------------------------------------------------
    */
    Route::middleware(['middleware' => 'auth:sanctum'])->group(function () {
        // Контент.
        Route::resource('posts', PostController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('posts.comments', CommentController::class);
        Route::apiResource('tags', TagController::class);

        Route::post('/posts/{post}/likes', [LikeController::class, 'likePost']);
        Route::delete('/posts/{post}/likes', [LikeController::class, 'unlikePost']);

        Route::post('/comments/{comment}/likes', [LikeController::class, 'likeComment']);
        Route::delete('/comments/{comment}/likes', [LikeController::class, 'unlikeComment']);

        // Dashboard - админка, ЛК.
        Route::get('/dashboard', DashboardController::class);
    });

    // Тестовый роут для отладки.
    Route::any('/test', TestController::class);

    Route::get('/health', function () {
        return response()->json(['status' => 'ok everything is working']);
    });

//    Route::get('/user', function (Request $request) {
//        return $request->user();
//    })->middleware('auth:sanctum');
});
