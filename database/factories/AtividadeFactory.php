<?php

namespace Database\Factories;

use App\Enum\AtividadeTipo;
use App\Models\Agente;
use App\Models\Endereco;
use App\Models\Passageiro;
use App\Models\Veiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Corrida>
 */
class AtividadeFactory extends Factory
{

    private $agente;
    private $veiculo;
    private $passageiro;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cancelada = $this->faker->boolean(30);
        if(!$this->agente){
            $veiculo = Veiculo::inRandomOrder()->first() ?? Veiculo::factory()->create();
        }
        return [
            'agente_id' => $this->agente ?? $veiculo->agente_id,
            'tipo' => AtividadeTipo::MotorcycleTrip->value,
            'passageiro_id' => $this->passageiro ?? Passageiro::inRandomOrder()->first() ?? Passageiro::factory(),
            'cancelada' => $cancelada,
            'data_finalizada' => $this->faker->date(),
            'nota_passageiro' => $this->faker->numberBetween(1,5),
            'nota_agente' => $this->faker->numberBetween(1,5),
            'obs_agente' => $this->faker->text(30),
            'obs_passageiro' => $this->faker->text(30),
            'justificativa_cancelamento' => $cancelada ? $this->faker->text(30) : null, 
            'veiculo_id' => $this->veiculo ?? $veiculo->id,
            'origem' => Endereco::factory(),
            'destino' => Endereco::factory()
        ];
    }

    public function setAgente($agente){
        $this->agente = $agente->id;
        $this->veiculo = $agente->veiculos->first()->id;
        return $this;
    }

    public function setPassageiro($passageiro){
        $this->passageiro = $passageiro->id;
        return $this;
    }

}
