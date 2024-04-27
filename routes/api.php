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

Route::group(['prefix' => 'auth'],function () {
    Route::post('login', [App\Http\Controllers\API\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\API\AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::group([ 'middleware' => ['auth:sanctum',config('jetstream.auth_session'),'verified' ]], function () {
    Route::apiResource('activities', App\Http\Controllers\API\AtividadeAPIController::class);
    Route::apiResource('vehicles', App\Http\Controllers\API\VeiculoAPIController::class);

    // Route::apiResource('pessoas', App\Http\Controllers\API\PessoaAPIController::class)
    //     ->except(['create', 'edit']);

    // Route::resource('agentes', App\Http\Controllers\API\AgenteAPIController::class)
    //     ->except(['create', 'edit']);

    // Route::resource('passageiros', App\Http\Controllers\API\PassageiroAPIController::class)
    //     ->except(['create', 'edit']);
});