<?php

namespace App\Rules;

use App\Models\Agente;
use App\Models\Passageiro;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserUniqueRule implements ValidationRule
{

    public function __construct(
        public $type = null
    ){}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($this->type == 'A'){
            if(Agente::whereHas('user',function($query) use($attribute,$value){
                $query->where($attribute,$value);
            })->get()->isNotEmpty()){
                $fail(__(":attribute already exists",['attribute' => __(ucfirst($attribute))]));
            }
        }else if($this->type == 'P'){
            if(Passageiro::whereHas('user',function($query) use($attribute,$value){
                $query->where($attribute,$value);
            })->get()->isNotEmpty()){
                $fail(__(":attribute already exists",['attribute' => __(ucfirst($attribute))]));
            }
        }else{
            if(User::where($attribute,$value)->get()->isNotEmpty()){
                $fail(__(":attribute already exists",['attribute' => __(ucfirst($attribute))]));
            }
        }
    }
}
