<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

    }
}
