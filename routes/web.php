<?php

use App\Http\Controllers\RolesController;
use App\Models\Roles;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
Route::get('/', function () {
    return view('welcome');
});
Route::resource('/roles', RolesController::class);