<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminOrderController;
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

//User Side
Route::middleware(['auth', 'non-admin'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('/', [MenuController::class, 'index']);
    Route::get('profile', [AuthController::class, 'profile']);

    Route::resource('/baskets', BasketController::class)->except('create', 'show', 'edit','destroy', 'update');
    Route::post('/basket/{id}', [BasketController::class, 'update']);
    Route::delete('/basket/{id}', [BasketController::class, 'detach']);
    Route::delete('/baskets', [BasketController::class, 'delete']);

    Route::get('/order', [OrderController::class, 'index']);
    Route::post('/order', [OrderController::class, 'store']);
    
    Route::get('/history', [HistoryController::class, 'index']);
});


//Admin Side
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

        Route::get('/order', [AdminOrderController::class, 'index']);
        Route::patch('/order-accept/{id}', [AdminOrderController::class, 'accept']);
        Route::patch('/order-decline/{id}', [AdminOrderController::class, 'decline']);
        Route::patch('/order-done/{id}', [AdminOrderController::class, 'complete']);
    });
});