<?php

namespace Database\Factories;

use App\Models\Endereco;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pessoa>
 */
class PessoaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker = \Faker\Factory::create('pt_BR');
        $tipo = $this->faker->numberBetween(1,2);
        return [
            'nome' => $this->faker->name,
            'tipo' => $tipo,
            'documento' => $tipo == 1 ? $this->faker->cpf : $this->faker->cnpj,
            'rg' => $this->faker->rg,
            'endereco_id' => Endereco::factory(),
            'creator_id' => User::factory()
        ];
    }
}
