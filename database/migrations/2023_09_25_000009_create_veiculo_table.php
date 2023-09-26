<?php

namespace Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    
    /**
     * Run the migrations.
     * @table veiculo
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculo', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo',['Moto','Carro']);
            $table->string('modelo', 45);
            $table->string('marca', 45);
            $table->string('chassi', 45)->nullable();
            $table->string('renavam', 45)->nullable();
            $table->string('placa', 45);
            $table->string('cor', 45);
            $table->tinyInteger('ativo')->nullable()->default('1');
            $table->foreignId('agente_id')->references('id')->on('agente');
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
        Schema::dropIfExists('veiculo');
    }
};
