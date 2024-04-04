<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
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
    Route::post('/cart', [CartController::class, 'show']);

    Route::post('/cart/add', [CartController::class, 'addProduct']);
    //Оформление заказа
    Route::middleware('auth:api')->post('/order-create', [OrderController::class, 'create']);
    //Просмотр заказов
    Route::get('/my-orders',[OrderController::class, 'show']);
});

Route::middleware(['auth:api','role:admin'])->group(function () {
    //Просмотр всех заказов
    Route::get('/orders',[OrderController::class, 'index']);
    //Создание продукта
    Route::post('/products/create',[ProductController::class, 'create']);
    //Редактирование продукта
    Route::patch('/products/update/{id}',[ProductController::class, 'update']);
    //Удаление продукта
    Route::delete('/products/destroy/{id}',[ProductController::class, 'destroy']);
    //Создание категории
    Route::post('/categories',[CategoryController::class, 'create']);
    //Редактирование категории
    Route::patch('/categories{id}',[CategoryController::class, 'update']);
    //Удаление категории
    Route::delete('/categories/destroy/{id}',[ProductController::class, 'destroy']);
});



















