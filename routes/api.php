<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// 
    Route::get('/registerform', [UserController::class, 'registerForm']);
    Route::get('/loginform', [UserController::class, 'loginForm']);
    Route::get('/info', [UserController::class, 'info']);
    Route::get('/forgot', [UserController::class, 'forgotPassForm']);
    Route::post('/forgot', [UserController::class, 'sendResetLinkEmail']);
    Route::get('/resetpassword/{token}/{email}', [UserController::class, 'resetForm']);
    Route::post('/resetPassword', [UserController::class, 'resetPassword']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');


    // 
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/',[ProductController::class,'api_product']);
    Route::get('/search/{id}',[ProductController::class,'api_search_product']);
    Route::get('/{id}',[ProductController::class,'api_single_product']);
    Route::get('/gallery/{id}',[ProductController::class,'api_gallery_by_product_id']);
    Route::post('/loadCart',[ProductController::class,'api_load_cart_product']);
    Route::get('/products-category/{id}',[ProductController::class,'api_product_cate']);
});
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/',[CategoriesController::class,'api_categories']);
    Route::get('/with-products',[CategoriesController::class,'api_categories_with_products']);
    Route::get('/{id}',[CategoriesController::class,'api_paginate_products_by_category']);
});
Route::prefix('brands')->name('brands.')->group(function () {
    Route::get('/',[BrandController::class,'api_brands']);
});