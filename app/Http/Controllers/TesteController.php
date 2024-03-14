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
        return view('testes.index');
    }


    /**
     * Process dataTable ajax response.
     *
     * @param \Yajra\Datatables\Datatables $datatables
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataTableData(Request $request){

        $query = Teste::with(['creator:id,name','editor:id,name','deleter:id,name']);
        $query = $this->filterDataTableData($query,$request->all());

        return DataTables::eloquent($query)
                          ->addColumn('select',function($reg){
                                return '';
                          })
                          ->editColumn('created_at',function($reg){
                                return $reg->created_at ? $reg->created_at->format('d/m/Y H:i') : '';
                          })
                          ->editColumn('updated_at',function($reg){
                                return $reg->updated_at ? $reg->updated_at->format('d/m/Y H:i') : '';
                          })
                          ->editColumn('deleted_at',function($reg){
                                return $reg->deleted_at ? $reg->deleted_at->format('d/m/Y H:i') : '';
                          })
                          ->addColumn('creator',function($reg){
                                return $reg->creator ? $reg->creator->name : '';
                          })
                          ->addColumn('editor',function($reg){
                                return $reg->editor ? $reg->editor->name : '';
                          })
                          ->addColumn('deleter',function($reg){
                                return $reg->deleter ? $reg->deleter->name : '';
                          })
                          ->editColumn('active',function($reg){
                             return $reg->active ? '<span class="badge badge-green uppercase">'.__('Yes').'</span>' : '<span class="badge badge-red uppercase">'.__('No').'</span>';
                          })
                          ->addColumn('action',function($reg){
                                return view('testes.action-buttons',['data' => $reg]);
                          })
                          ->rawColumns(['action','active'])
                          ->make();

    }

    private function filterDataTableData($query,$r){
        if(isset($r['dateTypeFilter'])){
            $field = null;
            switch($r['dateTypeFilter']){
                case 'C': $field = 'created_at'; break;
                case 'U': $field = 'updated_at'; break;
                case 'D': $field = 'deleted_at'; $query->onlyTrashed(); break;
            }
            if(isset($r['initialDate']) && $r['initialDate'])
                $query->where($field,'>=',$r['initialDate']);
            if(isset($r['endDate']) && $r['endDate'])
                $query->where($field,'<=',$r['initialDate']);
        }
        if(isset($r['activeFilter'])){
            if($r['activeFilter'] == 'true'){
                $query->active();
            }else{
                $query->unactive();
            }
        }
        return $query;
    }

}
