<?php

namespace Database\Factories;

use App\Models\Agente;
use App\Models\Veiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Veiculo>
 */
class VeiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new \Faker\Provider\FakeCar($this->faker));
        $agente = Agente::factory()->create();
        return [
            'tipo' => $this->faker->numberBetween(1,2),
            'modelo' => $this->faker->vehicle,
            'marca' => $this->faker->vehicleBrand,
            'chassi' =>  $this->faker->text(20),
            'renavam' => $this->faker->text(10),
            'placa' => $this->faker->vehicleRegistration,
            'cor' => $this->faker->hexColor, 
            'agente_id' => $agente->id,
            'creator_id' => $agente->id,
        ];
    }

        /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Veiculo $veiculo) {
            $veiculo->agente->update([
                'veiculo_ativo_id' => $veiculo->id
            ]);
        });
    }

}
