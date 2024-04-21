<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atividade', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('tipo')->comment('Corrida,entrega ou outra atividade');
            $table->tinyInteger('cancelada');
            $table->dateTime('data_finalizada')->nullable();
            $table->smallInteger('nota_passageiro')->nullable();
            $table->smallInteger('nota_agente')->nullable();
            $table->text('obs_agente')->nullable();
            $table->text('obs_passageiro')->nullable();
            $table->text('justificativa_cancelamento')->nullable();
            
            $table->foreignId('origem')->references('id')->on('endereco');
            $table->foreignId('destino')->references('id')->on('endereco');
            
            $table->text('rota_gerada')->nullable();
            $table->foreignId('agente_id')->references('id')->on('agente');
            $table->foreignId('passageiro_id')->references('id')->on('passageiro');
            $table->foreignId('veiculo_id')->references('id')->on('veiculo');
            $table->timestamps();
            
            try {
                Permission::create([ 'name' => 'atividades.view']);
            } catch (\Throwable $th) {
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('atividade');
                
        try {
            Permission::whereName('atividades.view')
                  ->delete();
        } catch (\Throwable $th) {
        }
    }
};