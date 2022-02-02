<?php

namespace App\Http\Requests\Ligne;

use Illuminate\Foundation\Http\FormRequest;

class ResauxRequest extends FormRequest
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
            'designation' => 'required|min:1|unique:networks'
        ];
    }
}
