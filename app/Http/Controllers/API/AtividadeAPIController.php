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
use App\Models\Endereco;
use App\Models\Passageiro;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        try {
            
            DB::beginTransaction();

            $destino = Endereco::firstOrCreate([
                'latitude' => $d['origin']['latitude'],
                'longitude' => $d['origin']['longitude']
            ],[
                'cep' => $d['origin']['zipcode'],
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
                'latitude' => $d['destiny']['latitude'],
                'longitude' => $d['destiny']['longitude'],
                'cep' => $d['destiny']['zipcode'],
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
                'passageiro_id' => Auth::id()
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
