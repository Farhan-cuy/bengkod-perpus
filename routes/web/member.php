<?php

use App\Http\Controllers\API\MemberController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:member'])->group(function () {

    Route::prefix('borrow')->controller(MemberController::class)->group(function () {
        Route::post('/', 'borrowBook');
        Route::delete('/cancel/{id}', 'cancelBorrow');
        Route::get('/active', 'activeLoans');
        Route::get('/history', 'borrowHistory');
        Route::get('/pending', 'borrowPending');
    });
});