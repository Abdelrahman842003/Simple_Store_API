<?php

    use App\Http\Controllers\Api\AuthController;
    use App\Http\Controllers\Api\CartController;
    use App\Http\Controllers\Api\OrderController;
    use App\Http\Controllers\Api\ProductsController;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */

    //auth
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);


    //products
    Route::get('products', [ProductsController::class, 'products']);
    Route::get('cart', [ProductsController::class, 'cart']);

    //cart
    Route::group(['prefix' => 'cart'], function () {
        Route::post('add_cart', [CartController::class, 'addToCart']);
        Route::post('update_cart', [CartController::class, 'UpdateCart']);
        Route::post('delete_cart', [CartController::class, 'deleteFromCart']);
        Route::get('user_cart', [CartController::class, 'userCart']);
    });

    //order
    Route::post('checkout', [OrderController::class, 'checkout']);

