<?php

namespace App\Http\Requests\Regionmc;

use Illuminate\Foundation\Http\FormRequest;

class RegionmcRequest extends FormRequest
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
            'designation' => 'required|min:3|unique:regionmcs'
        ];
    }
}
