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
Route::group(['prefix' => 'passageiros', 'as' => 'passageiros.', 'middleware' => 'permission:passageiro.view'],function(){
    Route::resource('/', App\Http\Controllers\PassageiroController::class);
        Route::patch('/update/{passageiro}', [App\Http\Controllers\PassageiroController::class,'update'])->name('update');
    Route::get('dataTableData',[App\Http\Controllers\PassageiroController::class,'dataTableData'])->name('dataTableData');
});
Route::group(['prefix' => 'atividades', 'as' => 'atividades.', 'middleware' => 'permission:atividades.view'],function(){
    Route::resource('/', App\Http\Controllers\AtividadeController::class);
        Route::patch('/update/{corrida}', [App\Http\Controllers\AtividadeController::class,'update'])->name('update');
    Route::get('dataTableData',[App\Http\Controllers\AtividadeController::class,'dataTableData'])->name('dataTableData');
});