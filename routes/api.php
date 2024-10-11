<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/',[ProductController::class,'api_product']);
    Route::get('/search/{id}',[ProductController::class,'api_search_product']);
    Route::get('/{id}',[ProductController::class,'api_single_product']);
    Route::post('/loadCart',[ProductController::class,'api_load_cart_product']);
});