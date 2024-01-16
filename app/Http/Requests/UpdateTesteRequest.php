<?php

namespace App\Http\Requests;

use App\Models\Teste;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTesteRequest extends FormRequest
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
        $rules = Teste::$rules;
        
        return $rules;
    }
}
