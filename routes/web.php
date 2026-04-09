<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');

Route::post('/login', [AuthController::class, 'login'])->name('doLogin');
Route::post('/register', [AuthController::class, 'register'])->name('doRegister');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
