<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Http;
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
        Schema::disableForeignKeyConstraints();
        Schema::create('agente', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('pessoa_id')->references('id')->on('pessoa');
            $table->foreignId('veiculo_ativo_id')->nullable()->references('id')->on('veiculo');
            $table->smallInteger('status');
            $table->timestamps();
            $table->softDeletes();
            $table->dateTime('data_desativacao')->nullable();
            $table->boolean('em_analise')->default(true);
            $table->foreignId('creator_id')->references('id')->on('users');
            $table->foreignId('editor_id')->nullable()->references('id')->on('users');
            $table->foreignId('deleter_id')->nullable()->references('id')->on('users');

            try {
                Permission::create(['name' => 'agentes.view']);
                Permission::create(['name' => 'agentes.create']);
                Permission::create(['name' => 'agentes.delete']);
            } catch (\Throwable $th) {
            }
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::drop('agente');
        Schema::enableForeignKeyConstraints();                
        Http::delete(config('app.firebase_url').'/availableAgents/.json')->throw();
        try {
            Permission::whereName('agentes.view')
                  ->orWhereName('agentes.create')
                  ->orWhereName('agentes.delete')
                  ->delete();
        } catch (\Throwable $th) {
        }
        Storage::disk('agent')->deleteDirectory('/');
    }
};