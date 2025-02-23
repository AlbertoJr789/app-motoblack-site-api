<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Actions\Fortify\CreateNewUser;
use App\Enum\VeiculoTipo;
use App\Models\Agente;
use App\Models\Passageiro;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //user admin for testing
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123123123'),
            'admin' => 1
        ]);


        $i = 5;
        \App\Models\Passageiro::factory($i)->create();
        \App\Models\Veiculo::factory($i)->create();

        $amount = 100;
        \App\Models\Atividade::factory($amount)->create();


       (new CreateNewUser)->create([
            'name' => 'alberto',
            'password' => '123123123'
        ],'P');

        $agent = (new CreateNewUser)->create([
            'name' => 'alberto',
            'password' => '123123123',
            'cep' => '01001000',
            'logradouro' => 'rua teste',
            'numero' => '123',
            'bairro' => 'centro',
            'cidade' => 'Formiga',
            'estado' => 'MG',
            'complemento' => '',
            'pais' => 'BR'
        ],'A');

        $agent->veiculo_ativo_id = \App\Models\Veiculo::factory()->create([
            'tipo' => VeiculoTipo::Motorcycle,
            'modelo' => 'fz250',
            'marca' => 'yamaha',
            'placa' => 'abc1234',
            'cor' => '#000000',        
            'agente_id' => $agent->id,
            'creator_id' => $agent->user_id,
            'active' => true
        ])->id;

        $agent->save();

    }
}
