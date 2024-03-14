<?php

namespace App\Http\Requests;

use App\Models\Pessoa;
use Illuminate\Foundation\Http\FormRequest;

class CreatePessoaRequest extends FormRequest
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
        return Pessoa::$rules;
    }
}
