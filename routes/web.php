<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\MenuController;

// Main Application
Route::get('login', function () {
    return view('login.index', [
        'title' => 'Login'
    ]);
})->name('login')->middleware('guest');

Route::get('register', function () {
    return view('register.index', [
        'title' => 'Register'
    ]);
})->name('register')->middleware('guest');

Route::post('register', [AuthController::class, 'register'])->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->middleware('guest');

Route::middleware(['auth', 'non-admin'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('/', [MenuController::class, 'index']);
    Route::get('profile', [AuthController::class, 'profile']);
});


//Admin Side Application
Route::prefix('admin')->group(function (){
    Route::get('login', function () {
        return view('admin.login', [
            'title' => 'Login'
        ]);
    })->middleware('guest');

    Route::post('login', [AdminAuthController::class, 'login'])->middleware('guest');

    Route::middleware('admin')->group(function () {
        Route::get('/', function () {
            return view('admin.blank', [
                'title' => 'Admin'
            ]);
        });

        Route::get('admin', [AdminAuthController::class, 'index']);

        Route::post('register', [AdminAuthController::class, 'register']);
        Route::post('logout', [AdminAuthController::class, 'logout']);

        Route::resource('/menus', AdminMenuController::class)->except('create', 'show');
        Route::patch('/menus/{id}/enable', [AdminMenuController::class, 'isEnable']);
    });
});