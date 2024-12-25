<?php

use Illuminate\Support\Facades\Route;
use App\Contexts\Book\Infrastructure\Http\Controllers\BookApiApiController;
use App\Contexts\User\Infrastructure\Http\Controllers\AuthApiController;

Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post('logout', [AuthApiController::class, 'logout']);
    Route::get('profile', [AuthApiController::class, 'profile']);

    Route::get('books', [BookApiApiController::class, 'index']);
    Route::get('books/{id}', [BookApiApiController::class, 'show']);

    Route::group(['middleware' => ['role:librarian']], function () {
        Route::post('books', [BookApiApiController::class, 'store']);
        Route::patch('books/{id}', [BookApiApiController::class, 'update']);
        Route::delete('books/{id}', [BookApiApiController::class, 'destroy']);
    });
});
