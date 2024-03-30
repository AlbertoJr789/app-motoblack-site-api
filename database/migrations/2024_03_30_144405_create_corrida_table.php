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
        Schema::create('corrida', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('cancelada');
            $table->dateTime('data_finalizada')->nullable();
            $table->smallInteger('nota_passageiro')->nullable();
            $table->smallInteger('nota_agente')->nullable();
            $table->text('obs_agente')->nullable();
            $table->text('obs_passageiro')->nullable();
            $table->text('justificativa_cancelamento')->nullable();
            $table->text('latitude_origem');
            $table->text('longitude_origem');
            $table->text('latitude_destino');
            $table->text('longitude_destino');
            $table->text('rota_gerada')->nullable();
            $table->foreignId('agente_id')->references('id')->on('agente');
            $table->foreignId('passageiro_id')->references('id')->on('passageiro');
            $table->foreignId('veiculo_id')->references('id')->on('veiculo');
            $table->timestamps();
            
            try {
                Permission::create([ 'name' => 'corridas.view']);
                Permission::create([ 'name' => 'corridas.create']);
                Permission::create([ 'name' => 'corridas.delete']);
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
        Schema::drop('corrida');
                
        try {
            Permission::whereName('corridas.view')
                  ->orWhereName('corridas.create')
                  ->orWhereName('corridas.delete')
                  ->delete();
        } catch (\Throwable $th) {
        }
    }
};