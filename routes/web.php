<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Models\Categories;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/main', function () {
    return view('main');
})->name('main');

// Регистрация
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Авторизация
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Главная
Route::get('/main', [ProductController::class, 'index'])->name('main');

// Категории
Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');;
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('category.show');

