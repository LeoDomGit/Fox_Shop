<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/',[ProductController::class,'api_product']);
    Route::get('/search/{id}',[ProductController::class,'api_search_product']);
    Route::get('/{id}',[ProductController::class,'api_single_product']);
    Route::get('/gallery/{id}',[ProductController::class,'api_gallery_by_product_id']);
    Route::post('/loadCart',[ProductController::class,'api_load_cart_product']);
});
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/',[CategoriesController::class,'api_categories']);
    Route::get('/with-products',[CategoriesController::class,'api_categories_with_products']);
    Route::get('/{id}',[CategoriesController::class,'api_paginate_products_by_category']);
});