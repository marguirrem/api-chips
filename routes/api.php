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
    Route::get('visitas',[VisitController::class, 'index']);
    Route::get('misvisitas',[VisitController::class, 'myVisits']);
    Route::post('visitas',[VisitController::class, 'store']);
    Route::get('foto/{path}', [VisitController::class, 'getImage'])->where('path', '.*');

});

Route::post('register', [AuthController::class,'register']);
Route::get('login', [AuthController::class,'login']);