<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
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
            $table->string('modelo',100);
            $table->string('marca',100);
            $table->string('chassi',45)->nullable();
            $table->string('renavam',45)->nullable();
            $table->string('placa',10);
            $table->string('cor',7)->comment('HEX');
            $table->dateTime('data_desativacao')->nullable();
            $table->foreignId('agente_id')->references('id')->on('agente');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('active')->default(false);
            $table->string('motivo_inativo')->nullable();
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

            Storage::disk('vehicle')->deleteDirectory('/');

        } catch (\Throwable $th) {
        }
    }
};