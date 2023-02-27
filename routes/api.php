<?php

use App\Http\Controllers\APIs\AuthController;
use App\Http\Controllers\APIs\ProductController;
use App\Http\Controllers\APIs\CartController;
use App\Http\Controllers\APIs\OrderController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassWord']);
});
//lấy tất cả sản phẫm
Route::get(
    '/products',
    [ProductController::class, 'index']
);
Route::middleware('auth:api')->group(
    function () {

        //thêm sản phẫm
        Route::post('/products', [ProductController::class, 'store']);
        //hiển thị một sản phẫm
        Route::get('/products/{id}', [ProductController::class, 'show']);
        //cập nhật sản phẫm
        Route::put('/products/{id}', [ProductController::class, 'update']);
        //xóa sp
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
        //lấy giỏ hàng
        Route::get('/cart', [CartController::class, 'index']);
        //thêm giỏ hàng
        Route::post('/cart', [CartController::class, 'store']);
        //cập nhật giỏ hàng
        Route::put('/cart/{productId}', [CartController::class, 'update']);
        //xóa giỏ hàng
        Route::delete('/cart/{cartItem}', [CartController::class, 'destroy']);
        //lấy đơn hàng
        Route::get('/orders', [OrderController::class, 'index']);
        //đặt hàng
        Route::post('/orders', [OrderController::class, 'store']);
        //chi tiết đơn hàng
        Route::get('/orders/{order}', [OrderController::class, 'show']);
    }

);
