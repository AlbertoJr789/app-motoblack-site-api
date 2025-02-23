<?php

namespace App\Http\Requests\API;

use App\Models\Agente;
use App\Models\Atividade;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Request\APIRequest;

class UpdateAtividadeAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Atividade::$rules;
        $user = Auth::user();

        if($user instanceof Agente){
            return array_merge($rules, [
                'nota_passageiro' => 'required|numeric|min:0|max:5',
                'obs_agente' => 'nullable|string',
            ]);
        }else{
            return array_merge($rules, [
                'nota_agente' => 'required|numeric|min:0|max:5',
                'obs_passageiro' => 'nullable|string',
            ]);
        }
    }
}
