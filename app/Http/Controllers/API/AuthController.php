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
        if(!Auth::attempt($request->only(['name','password']))){
            return response()->json([
                'message' => 'Credenciais inválidas'
            ],401);
        }
        
        $user = User::where('name',$request->name)->first();

        return response()->json([
            "message" => "Autenticado com sucesso",
            "token" => $user->createToken($user)->plainTextToken
        ]);

    }

    public function cadastro(StoreUserRequest $request)
    {

        $d = $request->all();

        $user = User::create([
            'name' => $d['name'],
            'password' => Hash::make($d['password'])
        ]);

        return response()->json([
            'message' => 'Usuário cadastrado com sucesso!',
            'user' => $user,
            'token' => $user->createToken($user)->plainTextToken
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
