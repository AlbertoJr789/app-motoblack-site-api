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
            $table->string('nome');
            $table->smallInteger('tipo')->nullable()->comment('1-PF,2-PJ');
            $table->string('documento')->nullable()->comment('CPF/CNPJ');
            $table->string('rg')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('active')->default(true);
            $table->foreignId('endereco_id')->nullable()->references('id')->on('endereco');
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