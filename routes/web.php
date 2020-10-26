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

    # Invoice PDF
    Route::get('/invoice/fees/{id}', '\App\Http\Controllers\InvoiceController@show')->name('invoice.show');

    # Search
    Route::post('/searchdata', '\App\Http\Controllers\ClientController@tnt_searchData')->name('searchdata');

    /*
     * Exports
     */
    Route::name('exports.')->prefix('export')->group(function() {
        Route::get('clients','\App\Http\Controllers\ExportController@clients')->name('clients');
        Route::get('fees','\App\Http\Controllers\ExportController@fees')->name('fees');
        Route::get('offices','\App\Http\Controllers\ExportController@offices')->name('offices');
        Route::get('users','\App\Http\Controllers\ExportController@users')->name('users');
    });

    /*
     * Site Configuration crud
     */
    Route::get('/settings','\App\Http\Controllers\SettingsController@index')->name('settings.index');
    Route::get('/settings/{setting}','\App\Http\Controllers\SettingsController@edit')->name('settings.edit');
    Route::patch('/settings/{setting}/update','\App\Http\Controllers\SettingsController@update')->name('settings.update');
});

