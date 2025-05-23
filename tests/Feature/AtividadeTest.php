<?php

namespace Tests\Feature;

use App\Helpers\FlexiblePolyline;
use App\Models\Atividade;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AtividadeTest extends TestCase
{
 

    public function test_trip_with_simulated_coords() {

        $atividade = Atividade::find(103);

        $flexPolyline = 'BG51qgnB9ts12C6hBmpB0jBgtB8GwqBAwWUsd8BsnB3cU3N3DrTkpC7GwbjI4c7Gkc3D4NjDoBvMkN3DgF7BgFrEopBU4NzF8VvH4N3DgF3X4SzU8f7Q0e7LoLvlBwW0FkIoBwHzP8VjDwH8B4DgP4NgU4Sj6BkkC7GsE7GUUwoCUgUrxB8BvbnB_JA';
        $coords = FlexiblePolyline::decode($flexPolyline);

        /**
         *  https://router.hereapi.com/v8/routes
         *    ?transportMode=car&origin=-20.45271,%20-45.43919&destination=-20.45740,-45.42524&apiKey=qOeyhjddKf_KQt3iImd4QaVhu9QBGFFeh2YKR9Q0B5w&return=polyline
         */
            
        // ])->throw();

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
     *  Agent going to passengers pickup position
     */
    public function test_trip_agent_with_simulated_coords() {
        $atividade = Atividade::find(103);


        $agent =Http::get(config('app.firebase_url')."/availableAgents/{$atividade->agente->uuid}/.json")->throw()->json();
        
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
