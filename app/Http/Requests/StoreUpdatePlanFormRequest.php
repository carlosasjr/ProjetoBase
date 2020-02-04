<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdatePlanFormRequest extends FormRequest
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

    public function attributes()
    {
        return [
            'description'        => 'Descrição',
            'price'              => 'Preço',
            'frequency_interval' => 'Intervalo',
            'cycles'             => 'Ciclos',
            'frequency'          => 'Frequência',
            'details'            => 'Detalhes',
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->segment(3);

        return [
            'description'        => "required|min:3|max:191|unique:plans,description,{$id},id",
            'price'              => 'required',
            'frequency_interval' => 'required',
            'cycles'             => 'required',
            'details'            => 'required',

            'frequency'       => [
                'required',
                Rule::in(['day', 'week', 'month', 'year']),
            ],
        ];
    }
}
