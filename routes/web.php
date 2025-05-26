<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    DashboardController,
    CuentasController,
    ClientesController,
    ServiciosController
};


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/cuentas', [CuentasController::class, 'index'])->name('cuentas');
Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes');
Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios');
