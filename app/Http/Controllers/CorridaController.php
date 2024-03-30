<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCorridaRequest;
use App\Http\Requests\UpdateCorridaRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CorridaRepository;
use Illuminate\Http\Request;
use Flash;
use App\Models\Corrida;
use Yajra\DataTables\Facades\DataTables;

class CorridaController extends AppBaseController
{
    /** @var CorridaRepository $corridaRepository*/
    private $corridaRepository;

    public function __construct(CorridaRepository $corridaRepo)
    {
        $this->corridaRepository = $corridaRepo;
    }

    /**
     * Display a listing of the Corrida.
     */
    public function index(Request $request)
    {
        return view('corridas.index');
    }


    public function store(Request $request){
        try {
            $d = $request->all();

            $this->corridaRepository->create($d);
            
            alert()->success(__('Success'),'Corrida '.__('added successfully!'));
        }
        catch (\Throwable $th) {
            \Log::error('Error while submiting Corrida: '.$th->getMessage());
            alert()->error(__('Error'),__('Whoops! Something went wrong.'));
        }
        return redirect()->back();
    }

    public function update(Corrida $corrida,Request $request){

        try {
            $d = $request->all();
            $corrida = $this->corridaRepository->update($d,$corrida->id);

            alert()->success(__('Success'),'Corrida '.__('updated successfully!'));
        }catch (\Throwable $th) {
            \Log::error('Error while submiting Corrida: '.$th->getMessage());
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

       $query = Corrida::select('corrida.*','C.name','E.name','D.name')
                                    ->leftjoin('users as C','C.id','corrida.creator_id')
                                    ->leftjoin('users as E','E.id','corrida.editor_id')
                                    ->leftjoin('users as D','D.id','corrida.deleter_id');
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
                               return view('corridas.action-buttons',['data' => $reg]);
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