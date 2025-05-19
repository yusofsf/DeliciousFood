<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\DrinkController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->middleware('throttle:10,1')
    ->controller(AuthController::class)->group(function () {

        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::get('/logout', 'logout')->middleware('auth:sanctum');

    });


Route::get('/email/verify', function () {
    return redirect('/verify-email');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/email-verified');
})->middleware('signed')->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return Response::json([
        'message' => 'email verification link send'
    ]);
})->middleware('auth:sanctum')->name('verification.send');

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(FoodController::class)->group(function () {
        Route::get('/foods', 'index');
        Route::post('/foods', 'store');
        Route::get('/foods/{food}', 'show');
        Route::post('/foods/{food}', 'update');
        Route::delete('/foods/{food}', 'destroy');
    });

    Route::controller(DrinkController::class)->group(function () {
        Route::post('/drinks', 'store');
        Route::get('/drinks/{drink}', 'show');
        Route::post('/drinks/{drink}', 'update');
        Route::delete('/drinks/{drink}', 'destroy');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index');
        Route::get('/orders/{order}/cancel', 'cancel');
        Route::get('/orders/{order}/show', 'show');
        Route::get('/orders/cart/confirm', 'confirm');
    });

    Route::controller(CartController::class)->group(function () {
        Route::post('/carts/add-to-cart', 'addToCart');
        Route::post('/carts/delete-from-cart', 'deleteFromCart');
        Route::patch('/carts/increaseQuantity', 'increaseQuantity');
        Route::patch('/carts/decreaseQuantity', 'decreaseQuantity');
        Route::get('/cart', 'show');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::delete('/users/user', 'destroy');
        Route::get('/users/user/orders', 'userOrders');
        Route::get('/users/user/orders/foods', 'userFoods');
        Route::get('/users/user/orders/drinks', 'userDrinks');
        Route::get('/users/user/orders/extras', 'userExtras');
    });
});

Route::get('/foods/burgers/show', [FoodController::class, 'burgers']);
Route::get('/foods/sandwiches/show', [FoodController::class, 'sandwiches']);
Route::get('/foods/extras/show', [FoodController::class, 'extras']);
Route::get('/drinks', [DrinkController::class, 'index']);