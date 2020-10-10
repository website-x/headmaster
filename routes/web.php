<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::redirect('/', '/login', 307);

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('dashboard', Controllers\DashboardController::class)->name('dashboard');

    Route::resources([
        'clients' => Controllers\ClientController::class,
        'fees' => Controllers\FeesController::class,
        'offices' => Controllers\OfficeController::class,
        'users' => Controllers\UserController::class,
    ]);

    Route::get('/invoice/fees/{id}', '\App\Http\Controllers\InvoiceController@show')->name('invoice.show');

    Route::get('/generate/{id}', '\App\Http\Controllers\DashboardController@generate_export')->name('generate.invoice');
    Route::get('/generatefees/{id}', '\App\Http\Controllers\FeesController@generate_fullexport')->name('generate.fullinvoice');
    Route::post('/searchdata', '\App\Http\Controllers\ClientController@tnt_searchData')->name('searchdata');
});

