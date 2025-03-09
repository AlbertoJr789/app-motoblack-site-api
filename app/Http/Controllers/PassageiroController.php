<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePassageiroRequest;
use App\Http\Requests\UpdatePassageiroRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PassageiroRepository;
use Illuminate\Http\Request;
use Flash;
use App\Models\Passageiro;
use Yajra\DataTables\Facades\DataTables;

class PassageiroController extends AppBaseController
{
    /** @var PassageiroRepository $passageiroRepository*/
    private $passageiroRepository;

    public function __construct(PassageiroRepository $passageiroRepo)
    {
        $this->passageiroRepository = $passageiroRepo;
    }

    /**
     * Display a listing of the Passageiro.
     */
    public function index(Request $request)
    {
        return view('passageiros.index');
    }

    public function update(Passageiro $passageiro,Request $request){

        try {
            $d = $request->all();

            $passageiro = $this->passageiroRepository->update($d,$passageiro->id);
            if(isset($d['active']) && $d['active'] == 'on'){
                $passageiro->user->motivo_inativo = null;
            }else{
                $passageiro->user->motivo_inativo = 'Passageiro inativado pelo sistema';
            }
            $passageiro->user->save();
            
            alert()->success(__('Success'),'Passageiro '.__('updated successfully!'));
        }catch (\Throwable $th) {
            \Log::error('Error while submiting Passageiro: '.$th->getMessage());
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

       $query = Passageiro::with(['user','rate'])->select('passageiro.*','C.name','E.name','D.name','P.nome as pessoa')
                                    ->leftjoin('pessoa as P','P.id','pessoa_id')
                                    ->leftjoin('users as C','C.id','passageiro.creator_id')
                                    ->leftjoin('users as E','E.id','passageiro.editor_id')
                                    ->leftjoin('users as D','D.id','passageiro.deleter_id');
       $query = $this->filterDataTableData($query,$request->all());
       return DataTables::eloquent($query)
                         ->addColumn('select',function($reg){
                               return '';
                         })
                         ->editColumn('pessoa',function($reg){
                            $rate =  view('components.star-rating',['rate' => $reg->rating])->render();
                            return "<div class=\"flex justify-start items-center\">
                                    <img src=\"{$reg->user->profile_photo_url}\" class=\"rounded-full w-10 h-10 mr-2\"> {$reg->pessoa} - {$rate}
                                    </div>";
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
                            return !$reg->user->motivo_inativo ? '<span class="badge badge-green uppercase">'.__('Yes').'</span>' : '<span class="badge badge-red uppercase">'.__('No').'</span>';
                         })
                         ->addColumn('action',function($reg){
                               return view('passageiros.action-buttons',['data' => $reg]);
                         })
                         ->rawColumns(['action','active','pessoa'])
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
                $query->whereHas('user',function($query){
                    $query->whereNull('motivo_inativo');
                });
            }else{
                $query->whereHas('user',function($query){
                    $query->whereNotNull('motivo_inativo');
                });
            }
        }
        return $query;
    }


}