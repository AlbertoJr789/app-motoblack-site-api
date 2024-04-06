<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCorridaRequest;
use App\Http\Requests\UpdateCorridaRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CorridaRepository;
use Illuminate\Http\Request;
use Flash;
use App\Models\Corrida;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
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

       $query = Corrida::select('corrida.*','PA.nome as agente','PP.nome as passageiro',DB::raw('CONCAT(V.marca,\' - \',V.modelo) as veiculo'))
                         ->join('agente as A','A.id','agente_id')
                         ->join('pessoa as PA','PA.id','A.pessoa_id')
                         ->join('passageiro as P','P.id','passageiro_id')
                         ->join('pessoa as PP','PP.id','P.pessoa_id')
                         ->join('veiculo as V','V.id','veiculo_id');

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
                         ->editColumn('data_finalizada',function($reg){
                               return $reg->data_finalizada ? $reg->data_finalizada->format('d/m/Y H:i') : '';
                         })
                         ->editColumn('cancelada',function($reg){
                               return $reg->cancelada ? '<span class="badge badge-green uppercase">'.__('Yes').'</span>' : '<span class="badge badge-red uppercase">'.__('No').'</span>';
                         })
                         ->editColumn('nota_passageiro',function($reg){
                             return $reg->nota_passageiro ? view('components.star-rating',['rate' => $reg->nota_passageiro])->render() : '';
                         })
                         ->editColumn('nota_agente',function($reg){
                            return $reg->nota_agente ? view('components.star-rating',['rate' => $reg->nota_agente])->render() : '';
                         })
                         ->addColumn('action',function($reg){
                               return view('corridas.action-buttons',['data' => $reg]);
                         })
                         ->rawColumns(['action','cancelada','nota_agente','nota_passageiro'])
                         ->make();

   }

    private function filterDataTableData($query,$r){
        if(isset($r['dateTypeFilter'])){
            $field = null;
            switch($r['dateTypeFilter']){
                case 'C': $field = 'created_at'; break;
                case 'U': $field = 'updated_at'; break;
            }
            if(isset($r['initialDate']) && $r['initialDate'])
                $query->where($field,'>=',$r['initialDate']);
            if(isset($r['endDate']) && $r['endDate'])
                $query->where($field,'<=',$r['initialDate']);
        }
       
        return $query;
    }


}