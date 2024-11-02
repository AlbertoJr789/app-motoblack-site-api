<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['as' => 'admin.', 'middleware' => ['auth:sanctum',config('jetstream.auth_session'),'verified' ]], function () {
    includeRouteFiles(__DIR__.'/admin/');
});

Route::get('registerPassenger',[App\Http\Controllers\API\AuthController::class, 'registerPassenger']);
Route::get('registerAgent',[App\Http\Controllers\API\AuthController::class, 'registerAgent']);
Route::post('createAgent',[App\Http\Controllers\API\AuthController::class, 'createAgent'])->name('createAgent');
Route::post('createPassenger',[App\Http\Controllers\API\AuthController::class, 'createPassenger'])->name('createPassenger');

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');
Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');
Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');
Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');
Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');
Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');


