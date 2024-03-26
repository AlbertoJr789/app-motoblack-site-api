<?php

use App\Models\Endereco;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['prefix' => 'pessoas', 'as' => 'pessoas.', 'middleware' => 'permission:pessoa.view'],function(){
    Route::resource('/', App\Http\Controllers\PessoaController::class);
    Route::patch('/update/{pessoa}', [App\Http\Controllers\PessoaController::class,'update'])->name('update');
    Route::get('dataTableData',[App\Http\Controllers\PessoaController::class,'dataTableData'])->name('dataTableData');
});

