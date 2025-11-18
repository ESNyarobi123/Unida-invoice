<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('session.auth');

Route::middleware('session.auth')->group(function () {
    Route::get('/', [InvoiceController::class, 'builder'])->name('invoice.builder');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
});
