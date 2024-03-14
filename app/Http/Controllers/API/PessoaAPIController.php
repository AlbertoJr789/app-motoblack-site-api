<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePessoaAPIRequest;
use App\Http\Requests\API\UpdatePessoaAPIRequest;
use App\Models\Pessoa;
use App\Repositories\PessoaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PessoaAPIController
 */
class PessoaAPIController extends AppBaseController
{
    private PessoaRepository $pessoaRepository;

    public function __construct(PessoaRepository $pessoaRepo)
    {
        $this->pessoaRepository = $pessoaRepo;
    }

    /**
     * Display a listing of the Pessoas.
     * GET|HEAD /pessoas
     */
    public function index(Request $request): JsonResponse
    {
        $pessoas = $this->pessoaRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pessoas->toArray(), 'Pessoas retrieved successfully');
    }

    /**
     * Store a newly created Pessoa in storage.
     * POST /pessoas
     */
    public function store(CreatePessoaAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $pessoa = $this->pessoaRepository->create($input);

        return $this->sendResponse($pessoa->toArray(), 'Pessoa saved successfully');
    }

    /**
     * Display the specified Pessoa.
     * GET|HEAD /pessoas/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Pessoa $pessoa */
        $pessoa = $this->pessoaRepository->find($id);

        if (empty($pessoa)) {
            return $this->sendError('Pessoa not found');
        }

        return $this->sendResponse($pessoa->toArray(), 'Pessoa retrieved successfully');
    }

    /**
     * Update the specified Pessoa in storage.
     * PUT/PATCH /pessoas/{id}
     */
    public function update($id, UpdatePessoaAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Pessoa $pessoa */
        $pessoa = $this->pessoaRepository->find($id);

        if (empty($pessoa)) {
            return $this->sendError('Pessoa not found');
        }

        $pessoa = $this->pessoaRepository->update($input, $id);

        return $this->sendResponse($pessoa->toArray(), 'Pessoa updated successfully');
    }

    /**
     * Remove the specified Pessoa from storage.
     * DELETE /pessoas/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Pessoa $pessoa */
        $pessoa = $this->pessoaRepository->find($id);

        if (empty($pessoa)) {
            return $this->sendError('Pessoa not found');
        }

        $pessoa->delete();

        return $this->sendSuccess('Pessoa deleted successfully');
    }
}
