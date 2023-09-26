<?php

namespace Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @table agente
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->references('id')->on('pessoa');
            $table->decimal('creditos', 10, 2)->default(0.0);
            $table->enum('tipo', ['Mototaxista','Motorista'])->default('Mototaxista');
            $table->string('cnh', 45)->nullable();
            $table->enum('status',['Inativo','Ativo','Banido','Reprovado','Aprovado'])->default('Inativo');
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
        Schema::dropIfExists('agente');
    }
};
