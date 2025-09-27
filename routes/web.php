<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UsersController::class,'index']);
Route::get('/impersonate/{id}', [UsersController::class,'impersonate'])->name('impersonate');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/setting', [UsersController::class, 'setting'])->name('setting');
