<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item.title' => 'required',
            'item.cost' => 'required',
            'item.date' => 'required|date|before_or_equal:today',
            'item.description' => 'nullable',
            'item.category' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'item.title.required' => 'Um estabelecimento deve ser informado!',
            'item.cost.required' => 'Um valor deve ser informado!',
            'item.date.required' => 'Uma data deve ser informada!',
            'item.date.date' => 'Uma data válida deve ser inserida!',
            'item.date.before_or_equal' => 'Data inválida: deve ser uma data anterior ou igual ao dia de hoje!',
            'item.category.required' => 'Uma categoria deve ser informada!',
        ];
    }
}
