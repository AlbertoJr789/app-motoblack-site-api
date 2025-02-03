<?php

namespace App\Http\Requests\API;

use App\Enum\VeiculoTipo;
use App\Models\Veiculo;
use Illuminate\Validation\Rule;
use InfyOm\Generator\Request\APIRequest;

class CreateVeiculoAPIRequest extends APIRequest
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
        return array_merge(Veiculo::$rules, [
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'type' => ['required',Rule::enum(VeiculoTipo::class)],
            'plate' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'document' => 'required|mimes:jpg,jpeg,png,pdf|max:3096',
        ]);
    }
}
