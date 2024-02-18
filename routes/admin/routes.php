<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['prefix' => 'testes', 'as' => 'testes.', 'middleware' => 'permission:testes.view'],function(){
    Route::get('/', [App\Http\Controllers\TesteController::class,'index'])->name('index');
    Route::get('dataTableData',[App\Http\Controllers\TesteController::class,'dataTableData'])->name('dataTableData');
});
