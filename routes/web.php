<?php

use App\Http\Controllers\RolesController;
use App\Models\Roles;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\HomeController;
Route::get('/', function () {
    return view('welcome');
});
Route::resource('/roles', RolesController::class);
Route::resource('/permissions', PermissionController::class);
Route::resource('/home', HomeController::class);