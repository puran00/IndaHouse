<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

//--странички
Route::get('/', [PageController::class, 'welcome'])->name('AboutUs');

Route::get('/registration', [PageController::class, 'RegistrationPage'])->name('RegistrationPage');
Route::get('/auth', [PageController::class, 'Auth'])->name('login');
Route::get('/user', [PageController::class, 'UserPage'])->name('UserPage');
Route::get('/catalog', [PageController::class, 'CatalogPage'])->name('CatalogPage');
Route::get('/cart', [PageController::class, 'CartPage'])->name('CartPage');
Route::get('/catalog/info/{product?}', [PageController::class, 'InfoPage'])->name('InfoPage');
Route::get('/contacts', [PageController::class, 'ContactsPage'])->name('ContactsPage');


//--функции
Route::post('/registration/save', [UserController::class, 'NewUserSave'])->name('NewUserSave');
Route::post('/login', [UserController::class, 'AuthSave'])->name('AuthSave');
Route::get('/exit', [UserController::class, 'logout'])->name('logout');

Route::get('/products', [ProductController::class, 'index'])->name('getProducts');


Route::post('/cart/add', [CartController::class, 'store'])->name('AddInCart');
Route::get('/cart/get', [CartController::class, 'index'])->name('GetCart');
Route::post('/cart/decrement', [CartController::class, 'update'])->name('DecrementInCart');
Route::post('/cart/delete', [CartController::class, 'deleteFromCart'])->name('deleteFromCart');
Route::post('/cart/delete', [CartController::class, 'destroy'])->name('deleteCartProduct');
Route::post('/order/completed', [\App\Http\Controllers\OrderController::class, 'store'])->name('completedOrder');

Route::get('/orders/get',[\App\Http\Controllers\OrderController::class, 'index'])->name('getOrders');
Route::get('/orders/user',[PageController::class, 'UserOrderPage'])->name('UserOrderPage');
Route::post('/orders/cancel', [\App\Http\Controllers\OrderController::class, 'cancelOrder'])->name('cancelOrder');


Route::group(['middleware'=>['auth', 'admin'], 'prefix'=>'admin'], function() {
   Route::get('/', [PageController::class, 'AdminPage'])->name('AdminPage');

   Route::get('/category', [PageController::class, 'CategoryPage'])->name('CategoryPage');
   Route::get('/category/add', [PageController::class, 'CategoryAddPage'])->name('CategoryAddPage');
   Route::get('/categories', [CategoryController::class, 'index'])->name('getCategories');
   Route::get('/category/edit/{category?}', [PageController::class, 'EditCategoryPage'])->name('EditCategoryPage');


   Route::post('/category/add/save', [CategoryController::class, 'store'])->name('AddCategory');
   Route::post('/category/edit/save', [CategoryController::class, 'update'])->name('EditCategorySave');
   Route::post('/category/delete', [CategoryController::class, 'destroy'])->name('DeleteCategory');

   Route::get('/products', [PageController::class, 'ProductPage'])->name('ProductPage');
   Route::get('/product/add', [PageController::class, 'ProductAddPage'])->name('ProductAddPage');
   Route::get('/product/edit/{product?}', [ProductController::class, 'edit'])->name('EditPageProduct');

   Route::post('/products/add/save', [ProductController::class, 'store'])->name('AddProduct');
   Route::post('/product/edit/save', [ProductController::class, 'update'])->name('EditProductSave');
   Route::post('/product/delete', [ProductController::class, 'destroy'])->name('DeleteProduct');

   Route::get('/orders', [PageController::class, 'AdminOrdersPage'])->name('AdminOrdersPage');
   Route::post('/orders/confirm', [\App\Http\Controllers\OrderController::class, 'confirmOrder'])->name('confirmOrder');
   Route::post('/orders/reject', [\App\Http\Controllers\OrderController::class, 'rejectOrder'])->name('rejectOrder');
});
