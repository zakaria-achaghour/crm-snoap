<?php

namespace App\Http\Requests\ville;

use Illuminate\Foundation\Http\FormRequest;

class VilleupdateRequest extends FormRequest
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
            'nom' => 'required|min:3|unique:villes,nom,'.$this->ville->id,
            'region' => 'required',
        ];
    }
}
