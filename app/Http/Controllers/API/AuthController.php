<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\Passageiro;
use App\Models\Veiculo;
use App\Rules\UserUniqueRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    
    public function registerPassenger(){
        return view('auth.register-passenger-form');
    }

    public function registerAgent(){
        return view('auth.register-agent-form');
    }

    public function createPassenger(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255', new UserUniqueRule('P')],
            'email' => ['nullable','email', 'max:255',new UserUniqueRule('P')],
            'password' => ['required',new Password(8)],
        ]); 
        $passenger = (new CreateNewUser)->create($request->all(),'P');
        return redirect(route('login'));
    }

    public function createAgent(Request $request){
        $request->validate([
            'driver_license' => ['required', 'mimes:jpg,jpeg,png,application/pdf', 'max:3096'],
            'vehicle_doc' => ['required', 'mimes:jpg,jpeg,png,application/pdf', 'max:3096'],
            'address_proof' => ['required', 'mimes:jpg,jpeg,png,application/pdf', 'max:3096'],
            'name' => ['required', 'string', 'max:255', new UserUniqueRule('A')],
            'email' => ['nullable','email', 'max:255',new UserUniqueRule('A')],
            'password' => ['required',new Password(8)],
            'tipo' => ['required'],
            'modelo' => ['required'],
            'marca' => ['required'],
            'placa' => ['required'],
            'cor' => ['required']
        ]); 
        DB::beginTransaction();        
            $agent = (new CreateNewUser)->create($request->except(['driver_license','vehicle_doc','address_proof']),'A');
            $agent->veiculo_ativo_id = Veiculo::create([
                'tipo' => $request['tipo'],
                'modelo' => $request['modelo'],
                'marca' => $request['marca'],
                'placa' => $request['placa'],
                'cor' => $request['cor'],        
                'agente_id' => $agent->id,
                'creator_id' => $agent->user_id,
                'active' => false
            ])->id;
            $agent->uploadFiles($request->files);
            $agent->save();
        DB::commit();
    
        return view('auth.register-agent-success');
    }

    public function login(LoginUserRequest $request)
    {
        
        $user = match($request->type) {
            'P' => Passageiro::withWhereHas('user',function($query) use ($request){
                    $query->whereName($request->name)
                          ->orWhere('email',$request->name)
                          ->orWhere('telefone',$request->name);
                })->first(),
            'A' => Agente::withWhereHas('user',function($query) use ($request){
                        $query->whereName($request->name)
                              ->orWhere('email',$request->name)
                              ->orWhere('telefone',$request->name);
            })->first(),
            default => null
        }; 

        if(!$user){
            return response()->json([
                'message' => __('User not found!')
            ],404);
        } 

        if(!Hash::check($request->password,$user->user->password)){
            return response()->json([
                'message' => __('Invalid password!')
            ],401);
        }

        if($user->user->motivo_inativo){
            return response()->json([
                'message' => __('Your account is not active!').' '.__('Reason').': '.__($user->user->motivo_inativo,locale:request()->getPreferredLanguage() ?? 'en_US')
            ],401);
        }
        
        return response()->json([
            "message" => __("User authenticated successfully"),
            "token" => $user->createToken($user->id)->plainTextToken
        ]);

    }

    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            "message" => __("Session terminated")
        ]);
    }
}
