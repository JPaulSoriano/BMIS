<?php

namespace App\Http\Requests\Route;

use Illuminate\Foundation\Http\FormRequest;

class StoreRouteRequest extends FormRequest
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
            'route_name' => 'required',
            'routes' => 'array',
            'routes.*' => 'required',
            'travel_time' => 'array',
            'travel_time.*' => 'required',
        ];
    }
}
