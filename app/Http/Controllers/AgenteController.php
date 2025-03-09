<?php

namespace App\Http\Controllers;

use App\Enum\AgenteStatus;
use App\Enum\VeiculoTipo;
use App\Http\Requests\CreateAgenteRequest;
use App\Http\Requests\UpdateAgenteRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AgenteRepository;
use Illuminate\Http\Request;
use Flash;
use App\Models\Agente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

            if($agente->em_analise){
                if(key_exists('active',$d)){
                    $d['em_analise'] = false;
                    $ativando = true;
                }
            }

            if(key_exists('active',$d)){
                $d['motivo_inativo'] = null;
            }
            
            DB::beginTransaction();
                $agente = $this->agenteRepository->update($d,$agente->id);
                if(isset($ativando)){
                    $agente->activeVehicle->update([
                        'tipo' => $d['tipo'],
                        'marca' => $d['marca'],
                        'modelo' => $d['modelo'],
                        'placa' => $d['placa'],
                        'renavam' => $d['renavam'],
                        'chassi' => $d['chassi'],
                        'cor' => $d['cor'],
                        'editor_id' => Auth::id()
                    ]);
                    $agente->pessoa->endereco->update([
                        'cep' => $d['cep'],
                        'logradouro' => $d['logradouro'], 
                        'numero' => $d['numero'],
                        'bairro' => $d['bairro'],
                        'complemento' => $d['complemento'],
                        'pais' => $d['pais'],
                        'estado' => $d['estado'],
                        'cidade' => $d['cidade']
                    ]);
                }
                $agente->user->update([
                    'motivo_inativo' => $d['motivo_inativo']
                ]);
            DB::commit();
            alert()->success(__('Success'),'Agente '.__('updated successfully!'));
        }catch (\Throwable $th) {
            DB::rollBack();
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

       $query = Agente::with(['activeVehicle','rate','user'])->select('agente.*','C.name','E.name','D.name','P.nome as pessoa')
                                    ->leftjoin('pessoa as P','P.id','agente.pessoa_id')
                                    ->leftjoin('users as C','C.id','agente.creator_id')
                                    ->leftjoin('users as E','E.id','agente.editor_id')
                                    ->leftjoin('users as D','D.id','agente.deleter_id');
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
                         ->editColumn('status',function($reg){
                            return match($reg->status){
                                AgenteStatus::Unavailable->value => '<span class="badge uppercase">'.__('Unavailable').'</span>',
                                AgenteStatus::Available->value => '<span class="badge badge-green uppercase">'.__('Available').'</span>',
                                AgenteStatus::Driving->value => '<span class="badge badge-yellow uppercase">'.__('Driving').'</span>',
                                default => ''
                            };
                         })
                         ->addColumn('active_vehicle',function($reg){
                            if($reg->activeVehicle){
                                $type = match($reg->activeVehicle->tipo){
                                    VeiculoTipo::Motorcycle => '<span class="badge badge-secondary uppercase">'.__('Motorcycle Pilot').'</span>',
                                    VeiculoTipo::Car => '<span class="badge badge-primary uppercase">'.__('Car Driver').'</span>',
                                    default => ''
                                };
                                return "$type - {$reg->activeVehicle->modelo} ({$reg->activeVehicle->placa})";
                            }
                            return '';
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
                            return !$reg->user->motivo_inativo ? '<span class="badge badge-green uppercase">'.__('Yes').'</span>' : '<span class="badge badge-red uppercase">'.__('No').' - '.__($reg->user->motivo_inativo).'</span>';
                         })
                         ->addColumn('action',function($reg){
                               return view('agentes.action-buttons',['data' => $reg]);
                         })
                         ->rawColumns(['action','active','status','tipo','localizacao','active_vehicle','pessoa'])
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

    public function getDocument(Agente $agente){
        $doc = $agente->getDocument(request()->query('doc'));
        if(!$doc) return $this->sendError(__('Not found',['attribute' => __('Document')]));
        return response($doc->content)->header('Content-Type',$doc->mimeType);
    }


}