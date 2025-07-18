<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVeiculoAPIRequest;
use App\Http\Requests\API\UpdateVeiculoAPIRequest;
use App\Models\Veiculo;
use App\Repositories\VeiculoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\VeiculoCollection;
use App\Models\Agente;
use App\Models\Passageiro;
use Illuminate\Support\Facades\Auth;

/**
 * Class VeiculoAPIController
 */
class VeiculoAPIController extends AppBaseController
{
    private VeiculoRepository $veiculoRepository;

    public function __construct(VeiculoRepository $veiculoRepo)
    {
        $this->veiculoRepository = $veiculoRepo;
    }

    /**
     * Display a listing of the Veiculos.
     * GET|HEAD /veiculos
     */
    public function index(Request $request): JsonResponse
    {
       
        try {
            
            if (Auth::user() instanceof Passageiro) {
                return $this->sendError('Passenger cannot access vehicles');
            } 

            $veiculos = $this->veiculoRepository
                ->paginate(
                    perPage: $request->get('amount') ?? 10,
                    simple: true,
                    beforePaginating: function($query) {
                        $query->where('agente_id',Auth::user()->id)
                              ->orderBy('created_at','desc');
                    }
                );
            return $this->sendResponse(
                ['result' => new VeiculoCollection($veiculos), 
                'hasMore' => $veiculos->hasMorePages()
            ],'Vehicles retrieved successfully');
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return $this->sendError('Couldn\'t retrieve user\'s vehicles');
        }
    }

    /**
     * Store a newly created Veiculo in storage.
     * POST /veiculos
     */
    public function store(CreateVeiculoAPIRequest $request): JsonResponse
    {

        if(!Auth::user() instanceof Agente){
            return $this->sendError('Only agents can register vehicles');
        }

        $input = $request->all();
        $input['active'] = false;
        $input['motivo_inativo'] = 'Veículo em análise';
        $input['agente_id'] = Auth::user()->id;

        $veiculo = $this->veiculoRepository->create($input);

        $veiculo->uploadDocument($input['document']);

        return $this->sendResponse($veiculo->toArray(), 'Veiculo saved successfully');
    }


    /**
     * Update the specified Veiculo in storage.
     * PUT/PATCH /veiculos/{id}
     */
    public function update($id, UpdateVeiculoAPIRequest $request): JsonResponse
    {
        $veiculo = $this->veiculoRepository->find($id);

        if (empty($veiculo)) {
            return $this->sendError('Veiculo not found',422);
        }

        if($veiculo->ativo){
            return $this->sendError(__('You can\'t update an active vehicle'),422);
        }

        $veiculo->uploadDocument($request->document);

        $veiculo->update([
            'motivo_inativo' => 'Veículo em análise',
            'active' => false
        ]);

        return $this->sendResponse($veiculo->toArray(), 'Veiculo updated successfully');
    }

    /**
     * Remove the specified Veiculo from storage.
     * DELETE /veiculos/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Veiculo $veiculo */
        $veiculo = $this->veiculoRepository->find($id);

        if (empty($veiculo)) {
            return $this->sendError('Veiculo not found',422);
        }

        if($veiculo->agente_id != Auth::user()->id){
            return $this->sendError('You don\'t have permission to delete this vehicle',422);
        }

        if(Auth::user()->veiculo_ativo_id == $veiculo->id){
            return $this->sendError(__('You can\'t delete an active vehicle you\'re using'),422);
        }


        $veiculo->delete();

        return $this->sendSuccess('Veiculo deleted successfully');
    }

        /**
     * Store a newly created Veiculo in storage.
     * POST /veiculos
     */
    public function setActive(Veiculo $veiculo): JsonResponse
    {

        if(!Auth::user() instanceof Agente){
            return $this->sendError('Only agents can register vehicles');
        }

        if($veiculo->agente_id != Auth::user()->id){
            return $this->sendError('You don\'t have permission to activate this vehicle');
        }

        if(!$veiculo->active){
            return $this->sendError(__('You can\'t use an inactive vehicle, check the inactive reason'),422);
        }

        Auth::user()->update(['veiculo_ativo_id' => $veiculo->id]);

        return $this->sendSuccess('Veiculo activated successfully');
    }

}
