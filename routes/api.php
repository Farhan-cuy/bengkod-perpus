<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\PustakawanController;
use App\Http\Controllers\API\LoanController;
use App\Http\Controllers\API\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/books', [BookController::class, 'showBook']); //udah
    Route::get('/books/{id_buku}', [BookController::class, 'showDetailBook']); //udah
    Route::get('/search/books', [BookController::class, 'searchBookByJudul']); //udah
    Route::get('/me', [AuthController::class, 'showProfile']); //udah
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/users', [AdminController::class, 'showUser']); //udah
    Route::get('/users/{id_user}', [AdminController::class, 'showIdUser']); //udah
    Route::post('/users', [AdminController::class, 'createUser']); //udah
    Route::put('/users/{id_user}', [AdminController::class, 'updateUser']); //udah
    Route::delete('/users/{id_user}', [AdminController::class, 'deleteUser']); //udah
});

Route::middleware(['auth:sanctum', 'role:member'])->group(function () {
    Route::post('/borrow', [MemberController::class, 'borrowBook']); //udah
    Route::delete('/borrow/cancel/{id}', [MemberController::class, 'cancelBorrow']); //udah
});

Route::middleware(['auth:sanctum', 'role:pustakawan'])->group(function () {
    Route::put('/pustakawan/validate-borrow/{id}', [PustakawanController::class, 'validateBorrow']); //udah
    Route::put('/pustakawan/validate-return/{id}', [PustakawanController::class, 'validateReturn']); //udah
});

Route::middleware(['auth:sanctum', 'role:admin|pustakawan'])->group(function () {
    Route::get('/loans', [LoanController::class, 'showDataLoan']); //udah
    Route::get('/loans/{id}', [LoanController::class, 'showDetailLoan']); //udah
    Route::post('/books', [BookController::class, 'createBook']); //udah
    Route::put('/books/{id_buku}', [BookController::class, 'updateBook']); //udah
    Route::delete('/books/{id_buku}', [BookController::class, 'deleteBook']); //udah
});


