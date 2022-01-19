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


Route::get('/book/other/random',[bookController::class,'otherRandom']);
Route::get('/book/mydata/',[bookController::class,'myData']);
Route::post('/book',[bookController::class,'store']);
Route::get('/book/{id}',[bookController::class,'show']);
Route::put('/book/{id}',[bookController::class,'update']);
Route::delete('/book/{id}',[bookController::class,'delete']);

