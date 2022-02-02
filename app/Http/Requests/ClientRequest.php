<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'nom' => 'required|max:30',
            'intitulé' => 'min:3|max:30',
            'ville' => '',
            'patente' => 'max:50',
            /*'ice' => [
                'nullable',
                'max:50',
                Rule::unique('clients')->where(function ($query) use ($request) {
                    $query->where('nom', '<>',$request->nom);
                })
            ],*/
            'i_f' => 'max:50',
            'autorisation' => 'max:50',
            'rc' => 'max:50',
            'adresse' => 'max:50',
            /*'pharmacien' => [
                'required',
                'max:50',
                Rule::unique('clients')->where(function ($query) use ($request) {
                    $query->where('ville_id', '=', $request->ville);
                })
            ],*/
            'contact' => 'max:50',
            'cin' => 'max:50',
            'fichier' => '',
            'motif' => 'requiredIf:bloquer,bloquer',
            'sage' => 'max:12',
        ];
    }
}
