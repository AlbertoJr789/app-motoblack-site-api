<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVeiculoRequest;
use App\Http\Requests\UpdateVeiculoRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\VeiculoRepository;
use Illuminate\Http\Request;
use Flash;
use App\Models\Veiculo;
use Yajra\DataTables\Facades\DataTables;

class VeiculoController extends AppBaseController
{
    /** @var VeiculoRepository $veiculoRepository*/
    private $veiculoRepository;

    public function __construct(VeiculoRepository $veiculoRepo)
    {
        $this->veiculoRepository = $veiculoRepo;
    }

    /**
     * Display a listing of the Veiculo.
     */
    public function index(Request $request)
    {
        return view('veiculos.index');
    }


    public function store(Request $request){
        try {
            $d = $request->all();

            $this->veiculoRepository->create($d);
            
            alert()->success(__('Success'),'Veiculo '.__('added successfully!'));
        }
        catch (\Throwable $th) {
            \Log::error('Error while submiting Veiculo: '.$th->getMessage());
            alert()->error(__('Error'),__('Whoops! Something went wrong.'));
        }
        return redirect()->back();
    }

    public function update(Veiculo $veiculo,Request $request){

        try {
            $d = $request->all();
            $veiculo = $this->veiculoRepository->update($d,$veiculo->id);

            alert()->success(__('Success'),'Veiculo '.__('updated successfully!'));
        }catch (\Throwable $th) {
            \Log::error('Error while submiting Veiculo: '.$th->getMessage());
            alert()->error(__('Error'),__('Whoops! Something went wrong.'));
        }
        return redirect()->back();
    }

    /**
    * Process dataTable ajax response.
    *
    * @param \Yajra\Datatables\Datatables $datatables
    * @return \Illuminate\Http\JsonResponse
    */
   public function dataTableData(Request $request){

       $query = Veiculo::select('veiculo.*','C.name','E.name','D.name','P.nome as dono')
                                    ->leftjoin('agente as A','A.id','agente_id')
                                    ->leftjoin('pessoa as P','P.id','A.pessoa_id')
                                    ->leftjoin('users as C','C.id','veiculo.creator_id')
                                    ->leftjoin('users as E','E.id','veiculo.editor_id')
                                    ->leftjoin('users as D','D.id','veiculo.deleter_id');
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
                         ->editColumn('tipo',function($reg){
                            switch($reg->tipo){
                                case 1: return '<span class="badge badge-secondary uppercase">'.__('Motorcycle').'</span>';
                                case 2: return '<span class="badge badge-primary uppercase">'.__('Car').'</span>';
                                default: return '';
                            }
                         })
                         ->editColumn('cor',function($reg){
                            return "<div style=\"background-color: $reg->cor;\" class=\"h-[25px] rounded rounded-sm\"><div>";
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
                               return view('veiculos.action-buttons',['data' => $reg]);
                         })
                         ->rawColumns(['action','active','tipo','cor'])
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
                $query->where('veiculo.active',true);
            }else{
                $query->where('veiculo.active',false);
            }
        }
        return $query;
    }


}