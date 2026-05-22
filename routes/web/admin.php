<?php

use App\Http\Controllers\API\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::prefix('users')->controller(AdminController::class)->group(function () {
        Route::get('/', 'showUser');
        Route::get('/pustakawan', 'showPustakawans');
        Route::get('/member', 'showMembers');
        Route::post('/', 'createUser');
        Route::post('/reset/{id_user}', 'resetPassword')->where('id_user', '[0-9]+');
        Route::put('/{id_user}', 'updateUser');
        Route::delete('/{id_user}', 'deleteUser');
        Route::get('/{id_user}', 'showIdUser')->where('id_user', '[0-9]+');
    });
});