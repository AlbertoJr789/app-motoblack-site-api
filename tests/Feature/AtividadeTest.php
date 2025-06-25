<?php

namespace Tests\Feature;

use App\Helpers\FlexiblePolyline;
use App\Models\Atividade;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AtividadeTest extends TestCase
{
 

    /**
     *  Moving Agent and passenger location to the destination
     */
    public function test_trip_with_simulated_coords() {

        $atividade = Atividade::find(110);

        $response = Http::get("https://router.hereapi.com/v8/routes?transportMode=car&origin={$atividade->origin->latitude},{$atividade->origin->longitude}&destination={$atividade->destiny->latitude},{$atividade->destiny->longitude}&apiKey=".config('app.here_api_key')."&return=polyline")->throw()->json();

        $coords = FlexiblePolyline::decode($response['routes'][0]['sections'][0]['polyline']);

        foreach ($coords['polyline'] as $coord) {
            dump("Current coordinate: " . implode(',', $coord) . PHP_EOL);
            Http::patch(config('app.firebase_url')."/availableAgents/{$atividade->agente->uuid}/.json",[
                'latitude' => $coord[0],
                'longitude' => $coord[1]    
            ]); 
            Http::patch(config('app.firebase_url')."/trips/{$atividade->uuid}/passenger/.json",[
                'latitude' => $coord[0],
                'longitude' => $coord[1]
            ]);
            sleep(0.3);
        }

    }

    /**
     *  Agent going to passengers origin position
     */
    public function test_trip_agent_with_simulated_coords() {
        $atividade = Atividade::find(103);

        $agent = Http::get(config('app.firebase_url')."/availableAgents/{$atividade->agente->uuid}/.json")->throw()->json();
        
        $origin = [
            'latitude' => $agent['latitude'],
            'longitude' => $agent['longitude']
        ];

        $destination = [
            'latitude' => $atividade->origin->latitude,
            'longitude' => $atividade->origin->longitude
        ];
    
        $response = Http::get("https://router.hereapi.com/v8/routes?transportMode=car&origin={$origin['latitude']},{$origin['longitude']}&destination={$destination['latitude']},{$destination['longitude']}&apiKey=".config('app.here_api_key')."&return=polyline")->throw()->json();
      
        $flexPolyline = $response['routes'][0]['sections'][0]['polyline'];

        $coords = FlexiblePolyline::decode($flexPolyline);

        foreach ($coords['polyline'] as $coord) {
            dump("Current coordinate: " . implode(',', $coord) . PHP_EOL);
            Http::patch(config('app.firebase_url')."/availableAgents/{$atividade->agente->uuid}/.json",[
                'latitude' => $coord[0],
                'longitude' => $coord[1]    
            ]); 
            sleep(0.3);
        }


    }

}
