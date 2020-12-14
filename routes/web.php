<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// All resources route

// Route::resource('buyers','buyerController',['only'=> ['index','show']]);

// Route::resource('sellers','sellerController',['except'=> ['create','edit']]);

// Route::resource('users','userController',['except'=> ['create','edit']]);

// Route::resource('categories','CategoryController',['only'=> ['index','show']]);

// Route::resource('products','ProductController',['only'=> ['index','show']]);

// Route::resource('transactions','TransactionController',['only'=> ['index','show']]);
