<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\BrandController;
Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->group(function () {
    Route::resource('/roles', RolesController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/categories', CategoriesController::class);
    Route::post('categories/uploadImages', [CategoriesController::class, 'UploadImages']);

    Route::resource('/brands', BrandController::class);
    Route::resource('/products', ProductController::class);

    Route::put('/products/switch/{id}', [ProductController::class, 'switchProduct']);
    Route::delete('/products/drop-image/{id}/{imageName}', [ProductController::class, 'removeImage']);
    Route::post('/products/set-image/{id}/{imageName}', [ProductController::class, 'setImage']);
    Route::post('/products/set-image/{id}/{imageName}', [ProductController::class, 'setImage']);
    Route::post('/products/upload-images/{id}', [ProductController::class, 'UploadImages']);
});
