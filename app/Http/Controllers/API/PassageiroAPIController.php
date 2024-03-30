<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePassageiroAPIRequest;
use App\Http\Requests\API\UpdatePassageiroAPIRequest;
use App\Models\Passageiro;
use App\Repositories\PassageiroRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PassageiroAPIController
 */
class PassageiroAPIController extends AppBaseController
{
    private PassageiroRepository $passageiroRepository;

    public function __construct(PassageiroRepository $passageiroRepo)
    {
        $this->passageiroRepository = $passageiroRepo;
    }

    /**
     * Display a listing of the Passageiros.
     * GET|HEAD /passageiros
     */
    public function index(Request $request): JsonResponse
    {
        $passageiros = $this->passageiroRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($passageiros->toArray(), 'Passageiros retrieved successfully');
    }

    /**
     * Store a newly created Passageiro in storage.
     * POST /passageiros
     */
    public function store(CreatePassageiroAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $passageiro = $this->passageiroRepository->create($input);

        return $this->sendResponse($passageiro->toArray(), 'Passageiro saved successfully');
    }

    /**
     * Display the specified Passageiro.
     * GET|HEAD /passageiros/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Passageiro $passageiro */
        $passageiro = $this->passageiroRepository->find($id);

        if (empty($passageiro)) {
            return $this->sendError('Passageiro not found');
        }

        return $this->sendResponse($passageiro->toArray(), 'Passageiro retrieved successfully');
    }

    /**
     * Update the specified Passageiro in storage.
     * PUT/PATCH /passageiros/{id}
     */
    public function update($id, UpdatePassageiroAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Passageiro $passageiro */
        $passageiro = $this->passageiroRepository->find($id);

        if (empty($passageiro)) {
            return $this->sendError('Passageiro not found');
        }

        $passageiro = $this->passageiroRepository->update($input, $id);

        return $this->sendResponse($passageiro->toArray(), 'Passageiro updated successfully');
    }

    /**
     * Remove the specified Passageiro from storage.
     * DELETE /passageiros/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Passageiro $passageiro */
        $passageiro = $this->passageiroRepository->find($id);

        if (empty($passageiro)) {
            return $this->sendError('Passageiro not found');
        }

        $passageiro->delete();

        return $this->sendSuccess('Passageiro deleted successfully');
    }
}
