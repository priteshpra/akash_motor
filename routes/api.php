<?php

use App\Http\Controllers\API\V1\ApiController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('v1/login', [ApiController::class, 'login']);
Route::get('v1/getProducts', [ApiController::class, 'getProducts']);
Route::post('v1/getCategory', [ApiController::class, 'getCategory']);
Route::post('v1/getSubCategory', [ApiController::class, 'getSubCategory']);
Route::post('v1/getCoasting', [ApiController::class, 'getCoasting']);
Route::post('v1/getSubProductData', [ApiController::class, 'getSubProductData']);
