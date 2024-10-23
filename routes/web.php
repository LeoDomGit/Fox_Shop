<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\AttributeController;


Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['reset' => true]);
Route::get('/registerform', [UserController::class, 'registerForm']);
Route::get('/loginform', [UserController::class, 'loginForm']);
Route::get('/info', [UserController::class, 'info']);
Route::get('/forgot', [UserController::class, 'forgotPassForm']);
Route::post('/forgot', [UserController::class, 'sendResetLinkEmail']);
Route::get('/resetpassword/{token}/{email}', [UserController::class, 'resetForm']);
Route::post('/resetPassword', [UserController::class, 'resetPassword']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


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
    Route::resource('/attributes', AttributeController::class);
});

