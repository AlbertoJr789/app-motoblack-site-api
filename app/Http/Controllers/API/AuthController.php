<?php

namespace App\Http\Controllers\API;

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

class AuthController extends Controller
{
    
    public function login(LoginUserRequest $request)
    {
        
        $user = match($request->type) {
            'P' => Passageiro::withWhereHas('user',function($query) use ($request){
                    $query->whereName($request->name)->orWhere('email',$request->name)->orWhere('telefone','LIKE',"%$request->telefone");
                })->first(),
            'A' => Agente::withWhereHas('user',function($query) use ($request){
                $query->whereName($request->name)->orWhere('email',$request->name)->orWhere('telefone','LIKE',"%$request->telefone");
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
