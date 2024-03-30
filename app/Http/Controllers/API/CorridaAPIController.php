<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCorridaAPIRequest;
use App\Http\Requests\API\UpdateCorridaAPIRequest;
use App\Models\Corrida;
use App\Repositories\CorridaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CorridaAPIController
 */
class CorridaAPIController extends AppBaseController
{
    private CorridaRepository $corridaRepository;

    public function __construct(CorridaRepository $corridaRepo)
    {
        $this->corridaRepository = $corridaRepo;
    }

    /**
     * Display a listing of the Corridas.
     * GET|HEAD /corridas
     */
    public function index(Request $request): JsonResponse
    {
        $corridas = $this->corridaRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($corridas->toArray(), 'Corridas retrieved successfully');
    }

    /**
     * Store a newly created Corrida in storage.
     * POST /corridas
     */
    public function store(CreateCorridaAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $corrida = $this->corridaRepository->create($input);

        return $this->sendResponse($corrida->toArray(), 'Corrida saved successfully');
    }

    /**
     * Display the specified Corrida.
     * GET|HEAD /corridas/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Corrida $corrida */
        $corrida = $this->corridaRepository->find($id);

        if (empty($corrida)) {
            return $this->sendError('Corrida not found');
        }

        return $this->sendResponse($corrida->toArray(), 'Corrida retrieved successfully');
    }

    /**
     * Update the specified Corrida in storage.
     * PUT/PATCH /corridas/{id}
     */
    public function update($id, UpdateCorridaAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Corrida $corrida */
        $corrida = $this->corridaRepository->find($id);

        if (empty($corrida)) {
            return $this->sendError('Corrida not found');
        }

        $corrida = $this->corridaRepository->update($input, $id);

        return $this->sendResponse($corrida->toArray(), 'Corrida updated successfully');
    }

    /**
     * Remove the specified Corrida from storage.
     * DELETE /corridas/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Corrida $corrida */
        $corrida = $this->corridaRepository->find($id);

        if (empty($corrida)) {
            return $this->sendError('Corrida not found');
        }

        $corrida->delete();

        return $this->sendSuccess('Corrida deleted successfully');
    }
}
