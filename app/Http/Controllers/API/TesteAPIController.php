<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTesteAPIRequest;
use App\Http\Requests\API\UpdateTesteAPIRequest;
use App\Models\Teste;
use App\Repositories\TesteRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TesteAPIController
 */
class TesteAPIController extends AppBaseController
{
    private TesteRepository $testeRepository;

    public function __construct(TesteRepository $testeRepo)
    {
        $this->testeRepository = $testeRepo;
    }

    /**
     * Display a listing of the Testes.
     * GET|HEAD /testes
     */
    public function index(Request $request): JsonResponse
    {
        $testes = $this->testeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($testes->toArray(), 'Testes retrieved successfully');
    }

    /**
     * Store a newly created Teste in storage.
     * POST /testes
     */
    public function store(CreateTesteAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $teste = $this->testeRepository->create($input);

        return $this->sendResponse($teste->toArray(), 'Teste saved successfully');
    }

    /**
     * Display the specified Teste.
     * GET|HEAD /testes/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Teste $teste */
        $teste = $this->testeRepository->find($id);

        if (empty($teste)) {
            return $this->sendError('Teste not found');
        }

        return $this->sendResponse($teste->toArray(), 'Teste retrieved successfully');
    }

    /**
     * Update the specified Teste in storage.
     * PUT/PATCH /testes/{id}
     */
    public function update($id, UpdateTesteAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Teste $teste */
        $teste = $this->testeRepository->find($id);

        if (empty($teste)) {
            return $this->sendError('Teste not found');
        }

        $teste = $this->testeRepository->update($input, $id);

        return $this->sendResponse($teste->toArray(), 'Teste updated successfully');
    }

    /**
     * Remove the specified Teste from storage.
     * DELETE /testes/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Teste $teste */
        $teste = $this->testeRepository->find($id);

        if (empty($teste)) {
            return $this->sendError('Teste not found');
        }

        $teste->delete();

        return $this->sendSuccess('Teste deleted successfully');
    }
}
