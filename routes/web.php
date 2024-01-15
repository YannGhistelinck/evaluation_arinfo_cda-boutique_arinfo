<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/ ', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/utilisateur', App\Http\Controllers\UserController::class);
Route::resource('/admin', App\Http\Controllers\AdminController::class);

Route::resource('/categories', App\Http\Controllers\CategoryController::class);
Route::resource('/subcategories', App\Http\Controllers\SubCategoryController::class);
Route::resource('/collections', App\Http\Controllers\CollectionController::class);
Route::resource('/promotions', App\Http\Controllers\PromotionController::class);
Route::resource('/products', App\Http\Controllers\ProductController::class);
Route::resource('/images', App\Http\Controllers\ImageController::class);
Route::resource('/orders', App\Http\Controllers\OrderController::class);
Route::resource('/products_orders', App\Http\Controllers\ProductOrderController::class);