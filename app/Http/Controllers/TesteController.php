<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTesteRequest;
use App\Http\Requests\UpdateTesteRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Teste;
use App\Repositories\TesteRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Yajra\DataTables\Facades\DataTables;

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
     * Store a newly created Teste in storage.
     */
    public function store(CreateTesteRequest $request)
    {
        $input = $request->all();
        $teste = $this->testeRepository->create($input);
        Flash::success('Teste saved successfully.');
        return response('Ok');
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

    /**
     * Process dataTable ajax response.
     *
     * @param \Yajra\Datatables\Datatables $datatables
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataTableData(Request $request){

        $query = Teste::whereNotNull('created_at');

        return DataTables::eloquent($query)
                          ->addColumn('select',function($reg){
                                return '';
                          })
                          ->addColumn('action',function($reg){
                                return view('testes.action-buttons',['data' => $reg]);
                          })
                          ->rawColumns(['action'])
                          ->make();

    }

}
