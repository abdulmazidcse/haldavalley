<?php

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
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', App\Http\Controllers\API\ProductController::class);
    Route::apiResource('sales', App\Http\Controllers\API\SalesController::class);
    Route::apiResource('inventory', App\Http\Controllers\API\InventoryController::class);
    Route::get('product-wise-sales-report', [App\Http\Controllers\API\ReportController::class, 'productWiseSales']);
    Route::get('date-wise-sales-report', [App\Http\Controllers\API\ReportController::class, 'dateWiseSales']);
    Route::get('product-wise-stock-report', [App\Http\Controllers\API\ReportController::class, 'productWiseStock']);
});  

Route::post('login', [App\Http\Controllers\API\UserController::class, 'login']);



 
