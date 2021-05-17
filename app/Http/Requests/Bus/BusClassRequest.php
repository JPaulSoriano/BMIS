<?php

namespace App\Http\Requests\Bus;

use Illuminate\Foundation\Http\FormRequest;

class BusClassRequest extends FormRequest
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
            'name' => 'required',
            'rate' => 'required|numeric|min:0',
            'point' => 'nullable|numeric|min:0',
            'flat_rate' => 'required|numeric|min:0'
        ];
    }
}
