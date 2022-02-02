<?php

namespace App\Http\Requests\fournisseur;

use Illuminate\Foundation\Http\FormRequest;

class FournisseurRequest extends FormRequest
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
            'code_sage' =>'required', 
            'designation' =>'required', 
            'bloquer' =>'required', 
            'motif' =>'required_if:bloquer,==,1',
        ];
    }
}
