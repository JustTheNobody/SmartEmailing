<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pid_list', [App\Http\Controllers\PidSalesController::class, 'index'])->name('pid_list');
Route::get('/import_pids', [App\Http\Controllers\PidSalesController::class, 'import'])->name('import_pids');
Route::get('/destroy_pids', [App\Http\Controllers\PidSalesController::class, 'destroy'])->name('destroy_pids');

