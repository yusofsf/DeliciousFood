<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('/checkout', 'checkout');
Route::view('/dashboard', 'dashboard');

Route::view('/login', 'auth/login');
Route::view('/register', 'auth/register');
Route::view('/verify-email', 'auth/verify-email');
Route::view('/email-verified', 'auth/email-verified');

Route::view('/users', 'users.index');
Route::view('/users/user/orders', 'users.user.orders');
Route::view('/users/user/orders/foods', 'users.user.orders.foods');
Route::view('/users/user/orders/drinks', 'users.user.orders.drinks');
Route::view('/users/user/orders/extras', 'users.user.orders.extras');

Route::view('/orders', 'orders.index');
Route::view('/orders/create', 'orders.create');
Route::view('/orders/{order}', 'orders.order.index');

Route::view('/foods', 'foods.index');
Route::view('/foods/create', 'foods.create');
Route::view('/foods/extras', 'foods.extras');
Route::view('/foods/{food}/update', 'foods.food.update');

Route::view('/drinks', 'drinks.index');
Route::view('/drinks/create', 'drinks.create');
Route::view('/drinks/{drink}/update', 'drinks.drink.update');
