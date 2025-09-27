<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UsersController::class,'index']);
Route::get('/impersonate/{id}', [UsersController::class,'impersonate'])->name('impersonate');
Route::get('/notifications/form', [NotificationController::class, 'notificationForm'])->name('notifications.post');

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/setting', [UsersController::class, 'setting'])->name('setting');
    Route::post('/update-setting', [UsersController::class, 'updateSetting'])->name('update.setting');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/send', [NotificationController::class, 'send'])->name('notifications.send');
    Route::get('/notifications/{id}/read', [NotificationController::class,'markAsRead'])->name('notifications.markAsRead');
    Route::get('/notifications/read-all',[NotificationController::class,'markAllRead'])->name('notifications.readAll');
});