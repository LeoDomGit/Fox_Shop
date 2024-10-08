<?php

use App\Http\Controllers\RolesController;
use App\Models\Roles;
use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
use Inertia\Inertia;
Route::get('/', function () {
    return view('welcome');
});
Route::resource('/roles', RolesController::class);
=======
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductsController;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->group(function () { 
    Route::resource('/roles', RolesController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/categories', CategoriesController::class);
    Route::resource('/products', ProductsController::class);
});
>>>>>>> Stashed changes
