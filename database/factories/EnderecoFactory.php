<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Endereco>
 */
class EnderecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { 
        return [
            'cep' => $this->faker->postCode,
            'logradouro' => $this->faker->streetName,
            'numero' => $this->faker->numberBetween(0,1000),
            'bairro' => $this->faker->streetName,
            'cidade' => 'Formiga',
            'estado' => 'MG',
            'pais' => 'BR',
            'complemento' => $this->faker->boolean(50) ? $this->faker->text(20) : null,
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->latitude(),
        ];
    }
}
