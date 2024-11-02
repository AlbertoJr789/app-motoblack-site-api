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
        Schema::create('passageiro', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('pessoa_id')->references('id')->on('pessoa');
            $table->foreignId('user_id')->references('id')->on('users');
            // $table->boolean('active')->default(true);
            $table->foreignId('creator_id')->references('id')->on('users');
            $table->foreignId('editor_id')->nullable()->references('id')->on('users');
            $table->foreignId('deleter_id')->nullable()->references('id')->on('users');
            
            try {
                Permission::create([ 'name' => 'passageiros.view']);
                Permission::create([ 'name' => 'passageiros.create']);
                Permission::create([ 'name' => 'passageiros.delete']);
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
        Schema::drop('passageiro');
                
        try {
            Permission::whereName('passageiros.view')
                  ->orWhereName('passageiros.create')
                  ->orWhereName('passageiros.delete')
                  ->delete();
        } catch (\Throwable $th) {
        }
    }
};