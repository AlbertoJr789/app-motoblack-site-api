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
use App\Models\Endereco;
use App\Models\Passageiro;
use App\Enum\VeiculoTipo;
use App\Http\Resources\AgenteResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use function Laravel\Prompts\search;

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
                    beforePaginating: function($query) use ($field) {
                        $query->where($field,Auth::user()->id)
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
        \Log::debug($d);
        try {
            
            DB::beginTransaction();

            $destino = Endereco::firstOrCreate([
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

            $origem = Endereco::firstOrCreate([
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
        /** @var Atividade $Atividade */
        $Atividade = $this->AtividadeRepository->find($id);

        if (empty($Atividade)) {
            return $this->sendError('Atividade not found');
        }

        return $this->sendResponse($Atividade->toArray(), 'Atividade retrieved successfully');
    }

    /**
     * Update the specified Atividade in storage.
     * PUT/PATCH /Atividades/{id}
     */
    public function update($id, UpdateAtividadeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Atividade $Atividade */
        $Atividade = $this->AtividadeRepository->find($id);

        if (empty($Atividade)) {
            return $this->sendError('Atividade not found');
        }

        $Atividade = $this->AtividadeRepository->update($input, $id);

        return $this->sendResponse($Atividade->toArray(), 'Atividade updated successfully');
    }

    /**
     *  Gets the most suited agent to take charge in the trip
     */
    public function drawAgent(Request $request){

        $agente = null;
        $distance = null;
        foreach($this->getActiveAgents($request->tripType) as $agent) {
            if($distance == null){
                $distance = haversine($request->latitude,$request->longitude,$agent['latitude'],$agent['longitude']);
                $agente = $agent['id']; 
            }else{
                $d = haversine($request->latitude,$request->longitude,$agent['latitude'],$agent['longitude']);
                if($d < $distance){
                    $distance = $d;
                    $agente = $agent['id'];
                }
            }
        }

        if($agente == null) return $this->sendError(__('Not found',['attribute' => __('Agent')]));
        return new AgenteResource(Agente::find($agente),true);
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
