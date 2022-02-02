<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'pharmacien' => '',
            'intitulé' => 'min:',
            'contact' => 'max:50',
            'cin' => 'max:50',
            'nom' => 'required',

            'patente' => 'nullable|unique:Clients,patente',
            'ice' => 'nullable|unique:Clients,ice,',
            'i_f' => 'nullable|unique:Clients,i_f',
            'rc' => 'nullable|unique:Clients,rc',
            'autorisation' => 'nullable|unique:Clients,autorisation',
               
            'fichier' => '',
            'motif' => 'requiredIf:bloquer,bloquer',
            'sage' => 'max:12',
        ];
    }
}
