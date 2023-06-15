<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\AuthController;
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
    
    Route::get('misvisitas',[VisitController::class, 'myVisits']);
    Route::post('visitas',[VisitController::class, 'store']);
    Route::get('visitas/foto/{path}', [VisitController::class, 'getImage'])->where('path', '.*');

});

Route::get('visitas',[VisitController::class, 'index']);

Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);