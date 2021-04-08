<?php

namespace App\Http\Requests\Terminal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTerminal extends FormRequest
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
            //
            'terminal_name' => 'required',
            'terminal_address' => 'required',
        ];
    }
}
