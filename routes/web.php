<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AccountController,
    CustomerController,
    ServiceController,
    MovementController
};


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/movements', [MovementController::class, 'index'])->name('movement');
Route::get('/accounts', [AccountController::class, 'index'])->name('account');
Route::get('/customers', [CustomerController::class, 'index'])->name('customer');
Route::get('/services', [ServiceController::class, 'index'])->name('service');
