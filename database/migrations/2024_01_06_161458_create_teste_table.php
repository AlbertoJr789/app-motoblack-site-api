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
        Schema::create('Teste', function (Blueprint $table) {
            $table->increments('id');
            $table->string('teste');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('active')->default(true);
            $table->foreignId('creator_id')->references('id')->on('users');
            $table->foreignId('editor_id')->nullable()->references('id')->on('users');
            $table->foreignId('deleter_id')->nullable()->references('id')->on('users');

            Permission::create([ 'name' => 'testes.view']);
            Permission::create([ 'name' => 'testes.create']);
            Permission::create([ 'name' => 'testes.delete']);
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
        Permission::whereName('testes.view')->delete();
        Permission::whereName('testes.create')->delete();
        Permission::whereName('testes.delete')->delete();
    }
};
