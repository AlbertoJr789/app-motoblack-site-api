<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//rotas da primeira versão
Route::group(['namespace' => 'App\Http\Controllers\API', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('pacotes', PacoteController::class);
});


Route::group(['prefix' => 'auth'],function () {
    Route::post('login', [App\Http\Controllers\API\AuthController::class, 'login']);
    Route::post('cadastro', [App\Http\Controllers\API\AuthController::class, 'cadastro']);
    Route::post('logout', [App\Http\Controllers\API\AuthController::class, 'logout'])->middleware('auth:sanctum');
});
