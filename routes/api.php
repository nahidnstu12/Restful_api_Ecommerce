<?php

use Illuminate\Http\Request;
// use Illuminate\Routing\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// All resources route

Route::resource('buyers','buyerController',['only'=> ['index','show']]);

Route::resource('sellers','sellerController',['except'=> ['create','edit']]);

Route::resource('users','userController',['except'=> ['create','edit']]);

Route::resource('categories','CategoryController',['only'=> ['index','show']]);

Route::resource('products','ProductController',['only'=> ['index','show']]);

Route::resource('transactions','TransactionController',['only'=> ['index','show']]);
