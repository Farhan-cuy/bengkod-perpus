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
    Route::get('/search/books', [BookController::class, 'searchBook']); //udah
    Route::get('/profile', [AuthController::class, 'showProfile']); //udah
    Route::put('/profile', [AuthController::class, 'updateProfile']); //udah
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/users', [AdminController::class, 'showUser']); //udah
    Route::get('/users/pustakawan', [AdminController::class, 'showPustakawans']);
    Route::get('/users/member', [AdminController::class, 'showMembers']);
    Route::post('/users', [AdminController::class, 'createUser']); //udah
    Route::post('/users/reset/{id_user}', [AdminController::class, 'resetPassword'])->where('id_user','[0-9]+'); //udah
    Route::put('/users/{id_user}', [AdminController::class, 'updateUser']); //udah
    Route::delete('/users/{id_user}', [AdminController::class, 'deleteUser']); //udah
    Route::get('/users/{id_user}', [AdminController::class, 'showIdUser'])->where('id_user','[0-9]+');
});

Route::middleware(['auth:sanctum', 'role:admin|pustakawan'])->group(function () {
    Route::get('/loans', [LoanController::class, 'showDataLoan']); //udah
    Route::get('/loans/pending', [LoanController::class, 'showLoanDipesan']); //udah
    Route::get('/loans/returned', [LoanController::class, 'showLoanDikembalikan']); //udah
    Route::get('/loans/{id}', [LoanController::class, 'showDetailLoan']); //udah
    Route::post('/books', [BookController::class, 'createBook']); //udah
    Route::put('/books/{id_buku}', [BookController::class, 'updateBook']); //udah
    Route::delete('/books/{id_buku}', [BookController::class, 'deleteBook']); //udah
    Route::put('/pustakawan/validate-borrow/{id}', [PustakawanController::class, 'validateBorrow']); //udah
    Route::put('/pustakawan/validate-return/{id}', [PustakawanController::class, 'validateReturn']);
});

Route::middleware(['auth:sanctum', 'role:member'])->group(function () {
    Route::post('/borrow', [MemberController::class, 'borrowBook']); //udah
    Route::delete('/borrow/cancel/{id}', [MemberController::class, 'cancelBorrow']); //udah
    Route::get('/borrow/active', [MemberController::class, 'activeLoans']);
    Route::get('/borrow/history', [MemberController::class, 'borrowHistory']);
    Route::get('/borrow/pending', [MemberController::class, 'borrowPending']); //udah
});

