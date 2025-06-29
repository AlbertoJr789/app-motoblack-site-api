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
        Schema::create('pessoa', function (Blueprint $table) {
            $table->id();
            $table->string('nome',160);
            $table->string('rg')->nullable();
            $table->smallInteger('tipo')->nullable()->comment('1-PF,2-PJ');
            $table->string('documento',18)->nullable()->comment('CPF/CNPJ');
            $table->foreignId('endereco_id')->nullable()->references('id')->on('endereco');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('creator_id')->references('id')->on('users');
            $table->foreignId('editor_id')->nullable()->references('id')->on('users');
            $table->foreignId('deleter_id')->nullable()->references('id')->on('users');
            
            try {
                Permission::create([ 'name' => 'pessoas.view']);
                Permission::create([ 'name' => 'pessoas.create']);
                Permission::create([ 'name' => 'pessoas.delete']);
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
        Schema::drop('pessoa');
                
        try {
            Permission::whereName('pessoas.view')
                  ->orWhereName('pessoas.create')
                  ->orWhereName('pessoas.delete')
                  ->delete();
        } catch (\Throwable $th) {
        }
    }
};