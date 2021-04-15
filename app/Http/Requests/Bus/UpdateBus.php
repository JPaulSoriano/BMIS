<?php

namespace App\Http\Requests\Bus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBus extends FormRequest
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
            'bus_no' => 'required',
            'bus_name' => 'required|string',
            'bus_plate' => 'required',
            'bus_seat' => 'required',
            'bus_class_id' => 'required|exists:bus_classes,id',
        ];
    }
}
