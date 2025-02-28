<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAtividadeAPIRequest;
use App\Http\Requests\API\UpdateAtividadeAPIRequest;
use App\Models\Atividade;
use App\Repositories\AtividadeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AtividadeCollection;
use App\Http\Resources\AtividadeResource;
use App\Models\Agente;
use App\Enum\AgenteStatus          ;
use App\Enum\AtividadeTipo;
use App\Enum\Cancelou;
use App\Models\Endereco;
use App\Models\Passageiro;
use App\Enum\VeiculoTipo;
use App\Http\Resources\AgenteResource;
use App\Models\User;
use Barryvdh\Snappy\Facades\SnappyImage;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * Class AtividadeAPIController
 */
class AtividadeAPIController extends AppBaseController
{
    private AtividadeRepository $AtividadeRepository;

    public function __construct(AtividadeRepository $AtividadeRepo)
    {
        $this->AtividadeRepository = $AtividadeRepo;
    }

    /**
     * Display a listing of the Atividades.
     * GET|HEAD /Atividades
     */
    public function index(Request $request): JsonResponse
    {
        $field = null;

        if (Auth::user() instanceof Passageiro) {
            $field = 'passageiro_id';
        } else if (Auth::user() instanceof Agente) {
            $field = 'agente_id';
        }
        if ($field) {
            $Atividades = $this->AtividadeRepository
                ->paginate(
                    eagerLoads: ['origin', 'destiny', 'agente', 'passageiro', 'veiculo'],
                    perPage: $request->get('amount') ?? 10,
                    simple: true,
                    beforePaginating: function($query) use ($field,$request) {
                        $query->where($field,Auth::user()->id)
                              ->whereNotNull('agente_id')
                              ->when(isset($request->unrated) || isset($request->cancelled),function($query){

                                if(isset($request->unrated)){ //looking for the latest unrated trip
                                    if(Auth::user() instanceof Agente){
                                        $query->whereNull('nota_passageiro');
                                    }else{
                                        $query->whereNull('nota_agente');
                                    }
                                    $query->where('cancelada',false);
                                }else{ //looking for the latest cancelled trip
                                    $query->where('cancelada',true);
                                }
                                
                              },function($query){
                                $query->whereNotNull('data_finalizada');
                              })
                              ->orderBy('created_at','desc');
                    }
                );
            return $this->sendResponse(
                ['result' => new AtividadeCollection($Atividades), 
                // 'currentPage' => $Atividades->currentPage(),
                'hasMore' => $Atividades->hasMorePages()
            ],'Activities retrieved successfully');
        } else {
            return $this->sendError('Couldn\'t retrieve user\'s activities');
        }
    }

    /**
     * Store a newly created Atividade in storage.
     * POST /Atividades
     */
    public function store(CreateAtividadeAPIRequest $request) 
    {
        $d = $request->all();
       
        // return $this->sendResponse(new AtividadeResource(Atividade::find(106)), 'Atividade saved successfully');
        try {
            
            DB::beginTransaction();

            $origem = Endereco::firstOrCreate([
                'latitude' => $d['origin']['latitude'],
                'longitude' => $d['origin']['longitude']
            ],[
                'cep' => $d['origin']['zipCode'],
                'logradouro' => $d['origin']['street'],
                'numero' => $d['origin']['number'],
                'bairro' => $d['origin']['neighborhood'],
                'cidade' => $d['origin']['city'],
                'estado' => $d['origin']['state'],
                'pais' => $d['origin']['country']
            ])->id;

            $destino = Endereco::firstOrCreate([
                'latitude' => $d['destiny']['latitude'],
                'longitude' => $d['destiny']['longitude']
            ],[
                'cep' => $d['destiny']['zipCode'],
                'logradouro' => $d['destiny']['street'],
                'numero' => $d['destiny']['number'],
                'bairro' => $d['destiny']['neighborhood'],
                'cidade' => $d['destiny']['city'],
                'estado' => $d['destiny']['state'],
                'pais' => $d['destiny']['country']
            ])->id;
                        
            $atividade = Atividade::create([
                'origem' => $origem,
                'destino' => $destino,
                'tipo' => intval($d['type']),
                'passageiro_id' => Auth::id(),
            ]);

            $atividade->update([
                'uuid' => $this->initTrip($atividade)
            ]);
            DB::commit();
            return $this->sendResponse(new AtividadeResource($atividade), 'Atividade saved successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            \Log::emergency('Error while creating activity: '. $th->getLine().'-'.$th->getMessage());
            return $this->sendError('Error while creating activity');
        }
    }

    /** 
     * Display the specified Atividade.
     * GET|HEAD /Atividades/{id}
     */
    public function show($id): JsonResponse
    {

        $atividade = Atividade::with(['origin', 'destiny', 'agente', 'passageiro', 'veiculo'])->find($id);
        if (empty($atividade)) {
            return $this->sendError('Atividade not found');
        }

        return $this->sendResponse(new AtividadeResource($atividade), 'Atividade retrieved successfully');
    }

    /**
     * Update the specified Atividade in storage.
     * PUT/PATCH /Atividades/{id}
     */
    public function update($id, UpdateAtividadeAPIRequest $request): JsonResponse
    {
     
        $d = $request->all();
        
        try{
            
            $atividade = Atividade::findOrFail($id);
            
            if(Auth::user() instanceof Passageiro){
                if(!$atividade->nota_agente){
                    $atividade->nota_agente = $d['nota_agente'];
                }
                $atividade->obs_passageiro = $d['obs_passageiro'];
            }else{
                if(!$atividade->nota_passageiro){
                    $atividade->nota_passageiro = $d['nota_passageiro'];
                }
                $atividade->obs_agente = $d['obs_agente'];
            }

            if(!$atividade->data_finalizada){
                $atividade->data_finalizada = now();
                $this->removeTrip($atividade);
            }
        
            $atividade->save();
            return $this->sendSuccess('Trip updated successfully');
        }catch (\Throwable $th) {
            \Log::error('Error updating trip: '. $th->getLine().'-'.$th->getMessage());
            return $this->sendError('Could not update trip',422);
        }
    }

    /**
     *  Gets the most suited agent to take charge in the trip
     */
    public function drawAgent(Atividade $atividade){

        $agente = null;
        $distance = null;

        if($atividade->agente_id) return new AgenteResource($atividade->agente,true);
        try {
            foreach($this->getActiveAgents($atividade->tipo) as $agent) {
                if($distance == null){
                    $distance = haversine($atividade->origin->latitude,$atividade->origin->longitude,$agent['latitude'],$agent['longitude']);
                    $agente = $agent['id']; 
                }else{
                    $d = haversine($atividade->origin->latitude,$atividade->origin->longitude,$agent['latitude'],$agent['longitude']);
                    if($d < $distance){
                        $distance = $d;
                        $agente = $agent['id'];
                    }
                }
            }

            if($agente == null) return $this->sendError(__('Not found',['attribute' => __('Agent')]));

            $agente = Agente::findOrFail($agente);
            $trips = collect(Http::get(config('app.firebase_url')."/availableAgents/{$agente->uuid}/trips/.json")->throw()->json());
            $trips->push([
                'id' => $atividade->id,
                'refused' => false
            ]);
            
            Http::patch(config('app.firebase_url')."/trips/{$atividade->uuid}/.json",[
                'agent' => [
                    'accepting' => true,
                ]
            ])->throw();
            Http::patch(config('app.firebase_url')."/availableAgents/{$agente->uuid}/.json",[
                'trips' => [
                  ...$trips->unique()->toArray()
                ]
            ])->throw();
            return new AgenteResource($agente,true);
       } catch (\Throwable $th) {
            \Log::error('Error while drawing agent: '. $th->getLine().'-'.$th->getMessage());
            $this->sendError(__('Not found',['attribute' => __('Agent')]));
       }
       
    }

    /**
     * Gets active agents in a realtime database (currently using firebase)
     * @return Collection
     */
    private function getActiveAgents($tripType){
        $type = match(intval($tripType)){
            AtividadeTipo::MotorcycleTrip->value => "?orderBy=\"type\"&startAt=".VeiculoTipo::Motorcycle->value."&endAt=".VeiculoTipo::Motorcycle->value,
            AtividadeTipo::CarTrip->value => "?orderBy=\"type\"&startAt=".VeiculoTipo::Car->value."&endAt=".VeiculoTipo::Car->value,
            default => ''
        };
        return collect(Http::get(config('app.firebase_url')."/availableAgents.json$type")->json());
    }

    /**
     * Initializes a trip in the realtime database (currently using firebase)
     */
    private function initTrip(Atividade $atividade){
        return Http::post(config('app.firebase_url')."/trips/.json",[
            'agent' => [
                'accepting' => false,
                'id' => null
            ],
            'cancelled' => false,
            'id' => $atividade->id,
            'passenger' => [
                'id' => $atividade->passageiro_id,
                'latitude' => $atividade->origin->latitude,
                'longitude' =>$atividade->origin->longitude
            ]
        ])->throw()->json()['name'];
    }

    /**
     * Removes a trip from the realtime database (currently using firebase)
     */
    private function removeTrip(Atividade $atividade){
        try{
            Http::delete(config('app.firebase_url')."/trips/{$atividade->uuid}/.json");
        }catch(\Throwable $th){
            \Log::error('Error removing trip: '. $th->getLine().'-'.$th->getMessage());
        }
    }


    public function acceptTrip(Atividade $atividade){
        
        if($atividade->agente_id) return $this->sendSuccess('Trip accepted successfully'); //already accepted
        try{
            if(!$atividade->uuid) throw new Exception('no uuid found');

            $atividade->agente_id = Auth::id();
            $atividade->veiculo_id = Auth::user()->veiculo_ativo_id;
            Http::delete(config('app.firebase_url')."/availableAgents/{$atividade->agente->uuid}/trips/.json"); //remove trips in queue since he's taking one
            Http::patch(config('app.firebase_url')."/trips/{$atividade->uuid}/.json",[
                'agent' => [
                    'id' => Auth::id()
                ]
            ])->throw();
            $atividade->save();
            return $this->sendSuccess('Trip accepted successfully');
        }catch (\Throwable $th) {
            \Log::error('Error accepting trip: '. $th->getLine().'-'.$th->getMessage());
            return $this->sendError('Could not accept trip',422);
        }
    }

    public function marker(User $user) 
    {
        $html = view('components.agent-marker')->with('avatar', $user->profile_photo_url)->render();

        $image = SnappyImage::loadHTML($html)
            ->setOption('format', 'png')
            ->setOption('transparent', true)
            ->setOption('width', 332); 

        return $image->inline();
    }

    public function cancel(Atividade $atividade,Request $request){

        $d = $request->all();

        try{

            if($atividade->data_finalizada) return $this->sendError(__('Trip already finished'),405);
            
            if($atividade->agente_id){
                $trips = collect(Http::get(config('app.firebase_url')."/availableAgents/{$atividade->agente->uuid}/trips/.json")->throw()->json());
            
                Http::patch(config('app.firebase_url')."/availableAgents/{$atividade->agente->uuid}/.json",[
                    'trips' => [
                      ...$trips->where('id','!=',$atividade->id)->toArray()
                    ]
                ])->throw();

                $atividade->cancelada = true;
                $atividade->data_finalizada = now();
                $atividade->justificativa_cancelamento = $d['reason'];
                $atividade->quem_cancelou = Auth::user() instanceof Agente ? Cancelou::Agente->value : Cancelou::Passageiro->value;
                $atividade->save();
            }else{
                $atividade->delete();
            }
            $this->removeTrip($atividade);
            return $this->sendSuccess('Trip cancelled successfully');
        }catch (\Throwable $th) {
            \Log::error('Error cancelling trip: '. $th->getLine().'-'.$th->getMessage());
            return $this->sendError('Could not cancel trip',422);
        }

    }


    // /**
    //  * Remove the specified Atividade from storage.
    //  * DELETE /Atividades/{id}
    //  *
    //  * @throws \Exception
    //  */
    // public function destroy($id): JsonResponse
    // {
    //     /** @var Atividade $Atividade */
    //     $Atividade = $this->AtividadeRepository->find($id);

    //     if (empty($Atividade)) {
    //         return $this->sendError('Atividade not found');
    //     }

    //     $Atividade->delete();

    //     return $this->sendSuccess('Atividade deleted successfully');
    // }
}
