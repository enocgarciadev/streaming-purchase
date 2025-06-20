<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AccountController,
    CustomerController,
    ServiceController,
    MovementController
};


Route::redirect('/', '/admin');

