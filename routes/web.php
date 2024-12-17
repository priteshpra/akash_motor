<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\AddformController;
// use Illuminate\Auth\Middleware\Authenticate;


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
// Login Route

// Route::middleware([Authenticate::class])->group(function () {
Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/del/{id}', [DashboardController::class, 'deleteUSer']);
Route::get('/', [LoginController::class, 'index']);
Route::get('register', function () {
    return view('register');
})->name('signup');
Route::post('submit', [LoginController::class, 'submitForm']);
Route::post('insertUser', [RegisterController::class, 'registerUser']);
Route::get('logout', [LoginController::class, 'logout']);
Route::resource('settings', SettingsController::class);
Route::resource('addform', AddformController::class);
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/subcategories', [SubCategoryController::class, 'index'])->name('subcategories.index');
Route::post('/subcategories', [SubCategoryController::class, 'store'])->name('subcategories.store');
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');
Route::get('/get-categorys/{categoryId}', [CategoryController::class, 'geCategorys'])->name('get.categorys');
Route::get('/get-subcategorys/{categoryId}', [SubCategoryController::class, 'geSubCategorys'])->name('get.subcategorys');
Route::get('/get-subcordinate/{categoryId}/{productId}', [AddformController::class, 'geSubCordinate'])->name('get.subcordinate');
Route::get('/get-subcategory/{categoryId}/{productId}', [AddformController::class, 'geSubCategory'])->name('get.subcategory');
Route::get('/get-subvalcategory/{createddate}/{productId}/{categoryId}', [AddformController::class, 'geSubValCategory'])->name('get.subvalcategory');

Route::put('/settings/{id}', [SettingsController::class, 'update']);

Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::delete('/subcategories/{id}', [SubCategoryController::class, 'destroy'])->name('subcategories.destroy');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

// Route for editing a product
// Route::get('/addform/{id}/edit', [AddformController::class, 'edit'])->name('addform.edit');
Route::post('/addform/{id}/edit', [AddformController::class, 'edit'])->name('addform.edit');


// Route for deleting a product
// Route::delete('/addform/{id}', [AddformController::class, 'destroy'])->name('addform.delete');
Route::delete('/addform/{id}/delete', [AddformController::class, 'destroy'])->name('addform.delete');

// });


// Route::get('/about/{name}', [Student::class, 'index', 'name']);
