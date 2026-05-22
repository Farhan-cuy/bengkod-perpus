<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\LoanController;
use App\Http\Controllers\API\PustakawanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:admin|pustakawan'])->group(function () {

    Route::prefix('books')->controller(BookController::class)->group(function () {
        Route::get('/', 'showBook');
        Route::get('/{id_buku}', 'showDetailBook');
        Route::post('/', 'createBook');
        Route::put('/{id_buku}', 'updateBook');
        Route::delete('/{id_buku}', 'deleteBook');
    });

    Route::prefix('loans')->controller(LoanController::class)->group(function () {
        Route::get('/', 'showDataLoan');
        Route::get('/pending', 'showLoanDipesan');
        Route::get('/borrowed', 'showLoanDipinjam');
        Route::get('/returned', 'showLoanDikembalikan');
        Route::get('/recap', 'rekapPeminjamanPerBulan');
        Route::get('/{id}', 'showDetailLoan');
    });

    Route::prefix('borrow')->controller(PustakawanController::class)->group(function () {
        Route::put('/validate/{id}', 'validateBorrow');
        Route::put('/return/{id}', 'validateReturn');
    });
});