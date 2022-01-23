<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\bookController;

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

Route::prefix('book')->group(function(){
    Route::get('/other/random',[bookController::class,'otherRandom']);
    Route::get('/other',[bookController::class,'other']);
    Route::get('/mydata',[bookController::class,'myData']);
    Route::post('/',[bookController::class,'store']);
    Route::get('/{id}',[bookController::class,'show']);
    Route::put('/{id}',[bookController::class,'update']);
    Route::delete('/{id}',[bookController::class,'delete']);
});


