<?php

namespace Database\Factories;

use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agente>
 */
class AgenteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        return [
            'tipo' => $this->faker->numberBetween(1,2),
            'status' => $this->faker->numberBetween(0,2),
            'pessoa_id' => Pessoa::factory(),
            'user_id' => $user->id,
            'creator_id' => $user->id
        ];
    }
}
