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
        Schema::create('veiculo', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('tipo');
            $table->string('modelo');
            $table->string('marca');
            $table->string('chassi')->nullable();
            $table->string('renavam')->nullable();
            $table->string('placa');
            $table->string('cor');
            $table->dateTime('data_desativacao')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('agente_id')->references('id')->on('agente');
            $table->boolean('active')->default(false);
            $table->foreignId('creator_id')->references('id')->on('users');
            $table->foreignId('editor_id')->nullable()->references('id')->on('users');
            $table->foreignId('deleter_id')->nullable()->references('id')->on('users');
            
            try {
                Permission::create([ 'name' => 'veiculos.view']);
                Permission::create([ 'name' => 'veiculos.create']);
                Permission::create([ 'name' => 'veiculos.delete']);
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
        Schema::disableForeignKeyConstraints();
        Schema::drop('veiculo');
        Schema::enableForeignKeyConstraints();
                
        try {
            Permission::whereName('veiculos.view')
                  ->orWhereName('veiculos.create')
                  ->orWhereName('veiculos.delete')
                  ->delete();
        } catch (\Throwable $th) {
        }
    }
};