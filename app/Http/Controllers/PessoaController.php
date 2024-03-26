<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePessoaRequest;
use App\Http\Requests\UpdatePessoaRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PessoaRepository;
use Illuminate\Http\Request;
use Flash;
use App\Models\Pessoa;
use App\Rules\DocumentRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class PessoaController extends AppBaseController
{
    /** @var PessoaRepository $pessoaRepository*/
    private $pessoaRepository;

    public function __construct(PessoaRepository $pessoaRepo)
    {
        $this->pessoaRepository = $pessoaRepo;
    }

    /**
     * Display a listing of the Pessoa.
     */
    public function index(Request $request)
    {
        return view('pessoas.index');
    }

    public function store(Request $request){
        try {
            $d = $request->all();

            $validator = Validator::make($d,[
                'documento' => new DocumentRule($d['tipo'])
            ]);

            if($validator->fails()){
                throw new ValidationException($validator,$validator->errors());
            }
            
            $pessoa = (new PessoaRepository)->create($d);
            
            if(isset($d['cep'])){
                $pessoa->update(['endereco_id' => $pessoa->endereco()->create($d)->id ]);
            }
            
            alert()->success(__('Success'),'Pessoa '.__('added successfully!'));
        } catch (ValidationException $ex) {
            alert()->warning(__('Warning!'),implode(',',Arr::flatten($ex->errors())));
        }
        catch (\Throwable $th) {
            \Log::error('Error while submiting Pessoa: '.$th->getMessage());
            alert()->error(__('Error'),__('Whoops! Something went wrong.'));
        }
        return redirect()->back();
    }

    public function update(Pessoa $pessoa,Request $request){

        try {
            $d = $request->all();
            $pessoa = (new PessoaRepository)->update($d,$pessoa->id);
                
            if($pessoa->endereco){
                $pessoa->endereco->update($d);
            }else{
                $pessoa->update(['endereco_id' => $pessoa->endereco()->create($d)->id]);
            }        
            alert()->success(__('Success'),'Pessoa '.__('updated successfully!'));
        }catch (\Throwable $th) {
            \Log::error('Error while submiting Pessoa: '.$th->getMessage());
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

       $query = Pessoa::select('pessoa.*','C.name','E.name','D.name')
                                    ->leftjoin('users as C','C.id','pessoa.creator_id')
                                    ->leftjoin('users as E','E.id','pessoa.editor_id')
                                    ->leftjoin('users as D','D.id','pessoa.deleter_id');
       $query = $this->filterDataTableData($query,$request->all());
       return DataTables::eloquent($query)
                         ->addColumn('select',function($reg){
                               return '';
                         })
                         ->editColumn('tipo',function($reg){
                            switch($reg->tipo){
                                case 1: return 'Pessoa Física'; 
                                case 2: return  'Pessoa Jurídica';
                            }
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
                         ->addColumn('endereco',function($reg){
                             return $reg->endereco_id ? $reg->endereco->formattedAddress : '-';
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
                               return view('pessoas.action-buttons',['data' => $reg]);
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