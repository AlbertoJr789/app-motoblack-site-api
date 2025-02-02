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
        $input = $request->all();

        $veiculo = $this->veiculoRepository->create($input);

        return $this->sendResponse($veiculo->toArray(), 'Veiculo saved successfully');
    }

    /**
     * Display the specified Veiculo.
     * GET|HEAD /veiculos/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Veiculo $veiculo */
        $veiculo = $this->veiculoRepository->find($id);

        if (empty($veiculo)) {
            return $this->sendError('Veiculo not found');
        }

        return $this->sendResponse($veiculo->toArray(), 'Veiculo retrieved successfully');
    }

    /**
     * Update the specified Veiculo in storage.
     * PUT/PATCH /veiculos/{id}
     */
    public function update($id, UpdateVeiculoAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Veiculo $veiculo */
        $veiculo = $this->veiculoRepository->find($id);

        if (empty($veiculo)) {
            return $this->sendError('Veiculo not found');
        }

        $veiculo = $this->veiculoRepository->update($input, $id);

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
            return $this->sendError('Veiculo not found');
        }

        $veiculo->delete();

        return $this->sendSuccess('Veiculo deleted successfully');
    }
}
