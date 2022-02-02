<?php

namespace App\Http\Requests\adv;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvRequest extends FormRequest
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
        return [
            'demandeur' => 'required',
            'network' => 'required',
            'rubrique' => 'required',
            'regionmc' => 'required',
            'ug' => 'required',
            'doctor' => 'required',
            'nature' => 'required',
            'dNature' => 'required',
            'budgetPrev' => 'required',
            'month' => 'required',
            'debut' => 'required|date',
            'fin' => 'required|date|after:debut',
        ];
    }
}
