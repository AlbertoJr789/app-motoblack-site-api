<?php

namespace App\Actions\Fortify;

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
        dd($input);
        if($input['email']==""){
            unset($input['email']);
        }
        
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255','unique:users,name'],
            'email' => ['sometimes','email', 'max:255', 'unique:users,email'],
            'password' => ['required',new Password],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'] ?? null,
            'password' => Hash::make($input['password']),
        ]); 

        // if(isset($input['mototaxista'])){

        // }

        // return;
    }
}
