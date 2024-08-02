<?php

namespace App\Actions\Fortify;

use App\Models\Agente;
use App\Models\Passageiro;
use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Rules\Password;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        if(isset($input['email']) && $input['email']==""){
            unset($input['email']);
        }
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255',],
            'email' => ['sometimes','email', 'max:255',],
            'password' => ['required',new Password],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();


        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'] ?? null,
            'telefone' => $input['telefone'] ?? null,
            'password' => Hash::make($input['password']),
        ]); 
        
        $ret = match(request()->query('type')){
            'A' => Agente::create([
                'user_id' => $user->id,
                'pessoa_id' => Pessoa::create([
                    'nome' => $user->name,
                    'creator_id' => $user->id,
                    'editor_id' => $user->id,
                ])->id,
                // 'tipo' => 1,
                'status'=> 0,
                'creator_id' => $user->id,
                'editor_id' => $user->id,
            ])->user,
            'P' => Passageiro::create([
                'user_id' => $user->id,
                'pessoa_id' => Pessoa::create([
                    'nome' => $user->name,
                    'creator_id' => $user->id,
                    'editor_id' => $user->id,
                ])->id,
                'creator_id' => $user->id,
                'editor_id' => $user->id,
            ])->user,
            default => $user
        };

        return $ret;
    }
}
