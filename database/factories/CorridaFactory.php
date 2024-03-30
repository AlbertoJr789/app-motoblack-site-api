<?php

namespace Database\Factories;

use App\Models\Agente;
use App\Models\Passageiro;
use App\Models\Veiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Corrida>
 */
class CorridaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cancelada = $this->faker->boolean(30);
        $veiculo = Veiculo::factory()->create();
        return [
            'agente_id' => $veiculo->agente_id,
            'passageiro_id' => Passageiro::factory(),
            'cancelada' => $cancelada,
            'data_finalizada' => $this->faker->date(),
            'nota_passageiro' => $this->faker->numberBetween(1,5),
            'nota_agente' => $this->faker->numberBetween(1,5),
            'obs_agente' => $this->faker->text(30),
            'obs_passageiro' => $this->faker->text(30),
            'justificativa_cancelamento' => $cancelada ? $this->faker->text(30) : null, 
            'veiculo_id' => $veiculo->id,
            'latitude_origem' => $this->faker->latitude,
            'longitude_origem' => $this->faker->longitude,
            'latitude_destino' => $this->faker->latitude,
            'longitude_destino' => $this->faker->longitude,
        ];
    }
}
