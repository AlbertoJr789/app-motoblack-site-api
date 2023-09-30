<?php

namespace Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
 
    /**
     * Run the migrations.
     * @table coordenadas
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('coordenadas', function (Blueprint $table) {
        //     $table->double('latitude',10,7);
        //     $table->double('longitude',10,7);
        //     $table->primary(['latitude','longitude']);
        //     $table->foreignId('endereco_id')->references('id')->on('endereco');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordenadas');
    }
};
