<?php

namespace Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    /**
     * Run the migrations.
     * @table endereco
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endereco', function (Blueprint $table) {
            $table->id();
            $table->string('cep',45);
            $table->string('logradouro',100);
            $table->string('numero',10)->nullable();
            $table->string('bairro',45)->nullable();
            $table->string('complemento',45)->nullable();
            $table->string('pais',45)->nullable();
            $table->string('estado',45)->nullable();
            $table->string('cidade',45)->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endereco');
    }
};
