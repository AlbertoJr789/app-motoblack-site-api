<?php

namespace Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @table corrida
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corrida', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agente_id')->references('id')->on('agente');
            $table->foreignId('passageiro_id')->references('id')->on('passageiro');
            $table->tinyInteger('cancelada')->nullable();
            $table->timestamp('data_finalizada')->nullable();
            $table->integer('nota_passageiro')->nullable();
            $table->integer('nota_agente')->nullable();
            $table->string('justificativa_cancelamento')->nullable();
            $table->foreignId('veiculo_id')->references('id')->on('veiculo');
            
            $table->double('lat_origem',10,7);
            $table->double('lon_origem',10,7);
            
            $table->double('lat_destino',10,7);
            $table->double('lon_destino',10,7);

            $table->foreign(['lat_origem','lon_origem'])->references(['latitude','longitude'])->on('coordenadas');
            $table->foreign(['lat_destino','lon_destino'])->references(['latitude','longitude'])->on('coordenadas');
    
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corrida');
    }
};
