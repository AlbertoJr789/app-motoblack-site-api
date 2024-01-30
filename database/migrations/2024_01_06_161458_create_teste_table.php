<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Teste', function (Blueprint $table) {
            $table->increments('id');
            $table->string('teste');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('criou')->references('id')->on('users');
            $table->foreignId('editou')->nullable()->references('id')->on('users');
            $table->foreignId('deletou')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Teste');
    }
};
