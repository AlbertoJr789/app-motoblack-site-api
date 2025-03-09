<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Repositories\AgenteRepository;
use Illuminate\Http\Request;
use App\Models\Agente;
use App\Models\Atividade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends AppBaseController
{
    
    /**
     * Display a listing of the Agente.
     */
    public function index(Request $request)
    {
        return view('dashboard');
    }

    /**
    * Process dataTable ajax response.
    *
    * @param \Yajra\Datatables\Datatables $datatables
    * @return \Illuminate\Http\JsonResponse
    */
   public function rankingTrips(Request $request){

       $query = Agente::with(['user','pessoa:id,nome'])->select('agente.*',DB::raw('COUNT(A.id) as total_trips'),DB::raw('AVG(nota_agente) as rate'))
                       ->join('atividade as A','A.agente_id','agente.id')
                       ->whereNotNull('A.data_finalizada')
                       ->where('A.cancelada',false)
                       ->groupBy('agente.id')
                       ->orderBy('total_trips','desc');

    //    $query = $this->filterRankingCorridas($query,$request->all());
       return DataTables::eloquent($query)
                        ->addColumn('agent',function($reg){
                            $rate =  view('components.star-rating',['rate' => $reg->rate])->render();
                            return "<div class=\"flex justify-start items-center\">
                                    <img src=\"{$reg->user->profile_photo_url}\" class=\"rounded-full w-10 h-10 mr-2\"> {$reg->pessoa->nome} - {$rate}
                                    </div>";
                        })
                        ->rawColumns(['agent'])
                         ->make();

   }

    private function filterRankingCorridas($query,$r){
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
                $query->whereNull('U.motivo_inativo');
            }else{
                $query->whereNotNull('U.motivo_inativo');
            }
        }
        return $query;
    }

    public function ongoingTrips(Request $request){
        $query = Atividade::with(['agente' => function($query){
                                $query->select('id','pessoa_id','user_id')
                                      ->with(['pessoa:id,nome','user','rate']) ;
                        },'origin','destiny'])
                          ->select('origem','destino') 
                          ->whereNull('data_finalizada')
                          ->where('cancelada',false)
                          ->latest();

        return DataTables::eloquent($query)
                         ->addColumn('route',function($reg){
                            return '<div class="flex flex-col gap-2">
                                <div class="flex items-center gap-4">
                                    <i class="fas fa-flag-checkered text-green-600"></i>
                                    <span>'.$reg->origin->formatted_address.'</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <i class="fas fa-flag text-red-600"></i>
                                    <span>'.$reg->destiny->formatted_address.'</span>
                                </div>
                            </div>';
                         })
                         ->addColumn('agent',function($reg){
                            $rate =  view('components.star-rating',['rate' => $reg->agente->rating])->render();
                            return "<div class=\"flex justify-start items-center\">
                                    <img src=\"{$reg->agente->user->profile_photo_url}\" class=\"rounded-full w-10 h-10 mr-2\"> {$reg->agente->pessoa->nome} - {$rate}
                                    </div>";
                         })
                         ->addColumn('start_time',function($reg){
                            return $reg->created_at->format('d/m/Y H:i');
                         })
                         ->rawColumns(['route','agent','start_time'])
                         ->make();
    }

    private function filterOngoingTrips($query,$r){
        if(isset($r['dateTypeFilter'])){
            $query->where('data_finalizada','>=',$r['initialDate']);
            $query->where('data_finalizada','<=',$r['endDate']);
        }
        return $query;
    }   

}