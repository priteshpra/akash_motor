<?php

use App\Http\Controllers\AddDataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\AddformController;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\FinaldataController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SetTaxController;
use App\Http\Controllers\ViewDataController;

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
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('auth');
Route::get('/del/{id}', [DashboardController::class, 'deleteUSer']);
Route::get('/', [LoginController::class, 'index']);
Route::get('register', function () {
    return view('register');
})->name('signup');
Route::post('submit', [LoginController::class, 'submitForm']);
Route::post('insertUser', [RegisterController::class, 'registerUser']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::resource('settings', SettingsController::class);
Route::resource('addform', AddformController::class);
Route::get('addform/list', [AddformController::class, 'list'])->name('addform.list');
Route::get('calculate/list', [CalculateController::class, 'list'])->name('calculate.list');
Route::get('viewdata/list', [ViewDataController::class, 'list'])->name('viewdata.list');
Route::get('adddata/list', [AddDataController::class, 'list'])->name('adddata.list');
Route::get('finaldata/add/{productId}/', [FinaldataController::class, 'add'])->name('finaldata.add');
Route::get('settax/list', [SetTaxController::class, 'list'])->name('settax.list');
Route::get('password/list', [PasswordController::class, 'set'])->name('password.set');
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
Route::put('/addform/{id}', [AddFormController::class, 'update'])->name('addform.update');
Route::post('/addform/mass-delete', [AddFormController::class, 'massDelete'])->name('addform.massDelete');
// });


// Route::get('/about/{name}', [Student::class, 'index', 'name']);
