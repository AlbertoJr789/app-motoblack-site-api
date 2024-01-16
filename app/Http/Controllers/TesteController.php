<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTesteRequest;
use App\Http\Requests\UpdateTesteRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TesteRepository;
use Illuminate\Http\Request;
use Flash;

class TesteController extends AppBaseController
{
    /** @var TesteRepository $testeRepository*/
    private $testeRepository;

    public function __construct(TesteRepository $testeRepo)
    {
        $this->testeRepository = $testeRepo;
    }

    /**
     * Display a listing of the Teste.
     */
    public function index(Request $request)
    {
        $testes = $this->testeRepository->paginate(10);

        return view('testes.index')
            ->with('testes', $testes);
    }

    /**
     * Show the form for creating a new Teste.
     */
    public function create()
    {
        return view('testes.create');
    }

    /**
     * Store a newly created Teste in storage.
     */
    public function store(CreateTesteRequest $request)
    {
        $input = $request->all();

        $teste = $this->testeRepository->create($input);

        Flash::success('Teste saved successfully.');

        return redirect(route('testes.index'));
    }

    /**
     * Display the specified Teste.
     */
    public function show($id)
    {
        $teste = $this->testeRepository->find($id);

        if (empty($teste)) {
            Flash::error('Teste not found');

            return redirect(route('testes.index'));
        }

        return view('testes.show')->with('teste', $teste);
    }

    /**
     * Show the form for editing the specified Teste.
     */
    public function edit($id)
    {
        $teste = $this->testeRepository->find($id);

        if (empty($teste)) {
            Flash::error('Teste not found');

            return redirect(route('testes.index'));
        }

        return view('testes.edit')->with('teste', $teste);
    }

    /**
     * Update the specified Teste in storage.
     */
    public function update($id, UpdateTesteRequest $request)
    {
        $teste = $this->testeRepository->find($id);

        if (empty($teste)) {
            Flash::error('Teste not found');

            return redirect(route('testes.index'));
        }

        $teste = $this->testeRepository->update($request->all(), $id);

        Flash::success('Teste updated successfully.');

        return redirect(route('testes.index'));
    }

    /**
     * Remove the specified Teste from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $teste = $this->testeRepository->find($id);

        if (empty($teste)) {
            Flash::error('Teste not found');

            return redirect(route('testes.index'));
        }

        $this->testeRepository->delete($id);

        Flash::success('Teste deleted successfully.');

        return redirect(route('testes.index'));
    }
}
