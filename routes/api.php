<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Регистрация
Route::post('/register' , [UserController::class, 'create' ]);
//Авторизация
Route::post('/login' , [AuthController::class, 'login' ]);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:api','role:user|admin'])->group(function (){
    //Просмотр категорий товаров
    Route::get('/categories',[CategoryController::class, 'index']);
    //Просмотр товаров определенной категории
    Route::get('/categories/{id}',[CategoryController::class, 'show']);
    //Просмотр всех товаров
    Route::get('/products',[ProductController::class, 'index']);
    //Просмотр своей корзины
    Route::post('/orders', [OrderController::class, 'checkout']);
    //Добавление товара в корзину
    Route::middleware('auth:api')->post('/category/product{id}', [ProductController::class, 'addToCart']);
});

Route::middleware(['auth:api','role:admin'])->group(function () {
    //Создание продукта
    Route::post('/products/create',[ProductController::class, 'create']);
    //Редактирование продукта
    Route::patch('/products{id}',[ProductController::class, 'update']);
    //Удаление продукта
    Route::delete('/products{id}',[ProductController::class, 'destroy']);
    //Создание категории
    Route::post('/categories',[CategoryController::class, 'create']);
    //Редактирование категории
    Route::patch('/categories{id}',[CategoryController::class, 'update']);
    //Удаление категории
    Route::delete('/categories{id}',[CategoryController::class, 'destroy']);
});



















