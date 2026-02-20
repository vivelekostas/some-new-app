<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/health', function () {
    return response()->json(['status' => 'ok everything is working']);
});

Route::any('/test', TestController::class);

// REGISTRATION PASSWORD
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
// Password reset (guest)
Route::post('/password/forgot', [PasswordController::class, 'forgot']);
Route::post('/password/reset', [PasswordController::class, 'reset']);
// Password update (auth user)
//Route::post('/password/update', [PasswordController::class, 'update'])
//    ->middleware('auth:sanctum');

Route::middleware(['middleware' => 'auth:sanctum'])->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('posts.comments', CommentController::class);

    Route::post('/posts/{post}/likes', [LikeController::class, 'likePost']);
    Route::delete('/posts/{post}/likes', [LikeController::class, 'unlikePost']);

    Route::post('/comments/{comment}/likes', [LikeController::class, 'likeComment']);
    Route::delete('/comments/{comment}/likes', [LikeController::class, 'unlikeComment']);
});
