<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAgenteRequest;
use App\Http\Requests\UpdateAgenteRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AgenteRepository;
use Illuminate\Http\Request;
use Flash;
use App\Models\Agente;
use Yajra\DataTables\Facades\DataTables;

class AgenteController extends AppBaseController
{
    /** @var AgenteRepository $agenteRepository*/
    private $agenteRepository;

    public function __construct(AgenteRepository $agenteRepo)
    {
        $this->agenteRepository = $agenteRepo;
    }

    /**
     * Display a listing of the Agente.
     */
    public function index(Request $request)
    {
        return view('agentes.index');
    }

    public function update(Agente $agente,Request $request){

        try {
            $d = $request->all();
            $agente = $this->agenteRepository->update($d,$agente->id);

            alert()->success(__('Success'),'Agente '.__('updated successfully!'));
        }catch (\Throwable $th) {
            \Log::error('Error while submiting Agente: '.$th->getMessage());
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

       $query = Agente::select('agente.*','C.name','E.name','D.name','P.nome as pessoa','U.name as usuario')
                                    ->leftjoin('pessoa as P','P.id','agente.id')
                                    ->leftjoin('users as U','U.id','agente.user_id')
                                    ->leftjoin('users as C','C.id','agente.creator_id')
                                    ->leftjoin('users as E','E.id','agente.editor_id')
                                    ->leftjoin('users as D','D.id','agente.deleter_id');
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
                         ->editColumn('status',function($reg){
                            switch($reg->status){
                                case 0: return '<span class="badge uppercase">'.__('Unavailable').'</span>';
                                case 1: return '<span class="badge badge-green uppercase">'.__('Available').'</span>';
                                case 2: return '<span class="badge badge-yellow uppercase">'.__('Driving').'</span>';
                                default: return '';
                            }
                         })
                         ->editColumn('tipo',function($reg){
                            switch($reg->tipo){
                                case 1: return '<span class="badge badge-secondary uppercase">'.__('Motorcycle Pilot').'</span>';
                                case 2: return '<span class="badge badge-primary uppercase">'.__('Car Driver').'</span>';
                                default: return '';
                            }
                         })
                         ->addColumn('localizacao',function($reg){
                            return ($reg->latitude && $reg->longitude) ? "<button class=\"btn-primary\" onclick=\"monitorarLocalizacao($reg->id)\"><i class=\"fa-solid fa-magnifying-glass\"></i></button>" : '';
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
                               return view('agentes.action-buttons',['data' => $reg]);
                         })
                         ->rawColumns(['action','active','status','tipo','localizacao'])
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
                $query->where('agente.active',true);
            }else{
                $query->where('agente.active',false);
            }
        }
        return $query;
    }


}