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


Route::group(['prefix' => 'agentes', 'as' => 'agentes.', 'middleware' => 'permission:agente.view'],function(){
    Route::resource('/', App\Http\Controllers\AgenteController::class);
        Route::patch('/update/{agente}', [App\Http\Controllers\AgenteController::class,'update'])->name('update');
    Route::get('dataTableData',[App\Http\Controllers\AgenteController::class,'dataTableData'])->name('dataTableData');
});
Route::group(['prefix' => 'veiculos', 'as' => 'veiculos.', 'middleware' => 'permission:veiculo.view'],function(){
    Route::resource('/', App\Http\Controllers\VeiculoController::class);
        Route::patch('/update/{veiculo}', [App\Http\Controllers\VeiculoController::class,'update'])->name('update');
    Route::get('dataTableData',[App\Http\Controllers\VeiculoController::class,'dataTableData'])->name('dataTableData');
});