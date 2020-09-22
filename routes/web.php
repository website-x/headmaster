<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('dashboard', Controllers\DashboardController::class)->name('dashboard');

    Route::resources([
        'clients' => Controllers\FeesController::class,
        'fees' => Controllers\FeesController::class,
        'offices' => Controllers\OfficeController::class,
    ]);
});
