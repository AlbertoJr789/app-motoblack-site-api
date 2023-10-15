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

class AuthController extends Controller
{
    
    public function login(LoginUserRequest $request)
    {
        $user = User::whereName($request->name)->orWhere('email',$request->name)->first();
        
        if(!$user){
            return response()->json([
                'message' => 'Usuário não encontrado!'
            ],404);
        } 

        if(!Hash::check($request->password,$user->password)){
            return response()->json([
                'message' => 'Senha inválida!'
            ],401);
        }
        
        return response()->json([
            "message" => "Autenticado com sucesso",
            "token" => $user->createToken($user->id)->plainTextToken
        ]);

    }

    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "Sessão encerrada"
        ]);
    }
}
