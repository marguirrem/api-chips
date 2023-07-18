<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/*
Route::middleware('auth:sanctum')->get('/misvisitas', function (Request $request) {
    return $request->user()->visitas;
});
*/
Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::get('myvisits',[VisitController::class, 'myVisits']);
    Route::post('visits',[VisitController::class, 'store']);
   
    Route::get('clients/search/{value}',[ClientController::class,'search']);   

    Route::get('products/search/{value}',[ProductController::class,'search']);   
    Route::get('products',[ProductController::class,'index']);    

    Route::get('mypayments',[PaymentController::class,'index']);   
    Route::post('payments',[PaymentController::class,'store']);   
    Route::get('typepayments',[PaymentController::class,'tipos_abonos']);  
    
    
});
Route::get('visits/photo/{path}', [VisitController::class, 'getImage'])->where('path', '.*');

Route::post('login', [AuthController::class,'login']);

