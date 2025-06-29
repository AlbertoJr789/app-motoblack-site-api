<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Http;
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
        Schema::create('atividade', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->smallInteger('tipo')->comment('Corrida,entrega ou outra atividade');
            
            $table->foreignId('passageiro_id')->references('id')->on('passageiro');
            $table->foreignId('agente_id')->nullable()->references('id')->on('agente');
            
            $table->tinyInteger('cancelada')->default(false);
            $table->dateTime('data_finalizada')->nullable();
            
            $table->decimal('nota_passageiro',2,1,true)->nullable();
            $table->decimal('nota_agente',2,1,true)->nullable();
            
            $table->text('obs_agente')->nullable();
            $table->text('obs_passageiro')->nullable();
            
            $table->text('justificativa_cancelamento')->nullable();
            $table->smallInteger('quem_cancelou')->nullable();
            
            $table->foreignId('veiculo_id')->nullable()->references('id')->on('veiculo');
            
            $table->foreignId('origem')->references('id')->on('endereco');
            $table->foreignId('destino')->references('id')->on('endereco');
            
            $table->timestamps();
            
            try {
                Permission::create([ 'name' => 'atividades.view']);
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
        Schema::drop('atividade');
        Http::delete(config('app.firebase_url').'/trips/.json')->throw();
        try {
            Permission::whereName('atividades.view')
                  ->delete();
        } catch (\Throwable $th) {
        }
    }
};