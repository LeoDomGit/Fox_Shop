<?php

use App\Http\Controllers\AttributeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersMngController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\WishlistController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

    Route::get('/registerform', [UserController::class, 'registerForm']);
    Route::get('/loginform', [UserController::class, 'loginForm']);
    Route::middleware('auth:sanctum')->get('/info', [UserController::class, 'info']);
    Route::get('/forgot', [UserController::class, 'forgotPassForm']);
   // routes/api.php
Route::delete('/user/delete/{id}', [UserController::class, 'destroy']);
Route::get('/user', [UserController::class, 'list']);


// Trong routes/api.php
Route::get('/orders/check-purchase/{productId}', [OrderController::class, 'checkPurchase']);


// Trong routes/api.php
Route::get('/comment/check-comment', [ReviewController::class, 'checkIfUserHasCommented']);



    Route::post('/forgot', [UserController::class, 'sendResetLinkEmail']);
    Route::get('/reset-password/{token}/{email}', [UserController::class, 'resetForm']);
    Route::post('/reset-password', [UserController::class, 'resetPassword']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/update/user', [UserController::class,'updateUser']);
    Route::post('/payment', [PaymentController::class, 'vnpay_payment']);
    Route::get('/payment/url', [PaymentController::class, 'vnpay_payment_url']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/vnpay-return', [PaymentController::class, 'vnpayreturn'])->name('payment.return');
    Route::post('/vnpay-data', [PaymentController::class, 'vnpay_data']);
    Route::get('/orders/{id_user}', [OrderController::class, 'getOrdersByUserId']);
    Route::get('/orders/detail/{id}', [OrderController::class, 'getOrdersById']);



    Route::resource('/review', ReviewController::class);
    Route::resource('/wishlist', WishlistController::class);
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/',[ProductController::class,'api_product']);
    Route::get('/search', [ProductController::class, 'api_search_product'])->name('search');
    Route::get('/best-seller',[ProductController::class,'api_product_best']);
    Route::get('/{slug}',[ProductController::class,'apiProductDetail']);
    Route::get('/gallery/{id}',[ProductController::class,'api_gallery_by_product_id']);
    Route::post('/loadCart',[ProductController::class,'api_load_cart_product']);
    Route::get('/products-category/{id}',[ProductController::class,'api_product_cate']);
    Route::get('/details/{slug}',[ProductController::class,'api_product_details']);

});

Route::prefix('attributes')->name('attributes.')->group (function () {
    Route::get('/',[AttributeController::class,'listAttr']);

});

Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/',[CategoriesController::class,'api_categories']);
    Route::get('/with-products',[CategoriesController::class,'api_categories_with_products']);
    Route::get('/{slug}',[CategoriesController::class,'api_paginate_products_by_category']);
});
Route::prefix('brands')->name('brands.')->group(function () {
    Route::get('/',[BrandController::class,'api_brands']);
});
Route::prefix('post')->name('post.')->group(function () {
    Route::get('/',[PostController::class,'api_post']);
    Route::get('/{slug}',[PostController::class,'api_post_detail']);
});
Route::prefix('voucher')->name('voucher.')->group(function () {
    Route::post('/',[VoucherController::class,'api_voucher_user']);
    Route::post('/validate-voucher', [VoucherController::class, 'validateVoucher']);
    Route::delete('/user_vouchers',[VoucherController::class,'deleteVoucher']);
    Route::get('/{id_user}',[VoucherController::class,'api_voucher_user_voucher']);
});
Route::prefix('comment')->name('comment.')->group(function () {
    Route::get('/',[ReviewController::class,'getAllComments']);
});
Route::prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/list/{id_user}', [WishlistController::class, 'getAllListByUser']);
});