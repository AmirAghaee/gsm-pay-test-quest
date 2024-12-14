<?php

use App\Http\Controllers\V1\LogController;
use App\Http\Middleware\AuthenticateJwt;
use Illuminate\Support\Facades\Route;

Route::middleware(AuthenticateJwt::class)->group(function () {
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
});
