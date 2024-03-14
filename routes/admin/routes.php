<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['prefix' => 'pessoas', 'as' => 'pessoas.', 'middleware' => 'permission:pessoa.view'],function(){
    Route::get('/', [App\Http\Controllers\PessoaController::class,'index'])->name('index');
    Route::get('dataTableData',[App\Http\Controllers\PessoaController::class,'dataTableData'])->name('dataTableData');
});