<?php

namespace App\Http\Requests\Ride;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRideRequest extends FormRequest
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
        $today = now()->toDateString();
        return [
            'route_id' => 'required|integer|exists:routes,id',
            'bus_id' => 'required|integer|exists:buses,id',
            'departure_time' => 'required|date_format:H:i',
            'auto_confirm' => 'boolean',
            'ride_type' => 'required|string',
            'ride_date' => "exclude_if:ride_type,cyclic|required|date|after_or_equal:$today",
            'days' => 'exclude_if:ride_type,single|required|array|min:1|',
            'start_date' => "exclude_if:ride_type,single|required|date|after_or_equal:$today",
            'end_date' => 'nullable|date|after:start_date'
        ];
    }
}
