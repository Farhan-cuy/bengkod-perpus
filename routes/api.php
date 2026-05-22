<?php

use App\Http\Controllers\API\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/books', [BookController::class, 'showBook']);
    Route::get('/books/{id_buku}', [BookController::class, 'showDetailBook']);
    Route::get('/search/books', [BookController::class, 'searchBook']);
    Route::get('/profile', [AuthController::class, 'showProfile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
});

Route::prefix('admin')->group(function () {
    require __DIR__ . '/web/admin.php';
});

Route::prefix('pustakawan')->group(function () {
    require __DIR__ . '/web/pustakawan.php';
});

Route::prefix('member')->group(function () {
    require __DIR__ . '/web/member.php';
});

