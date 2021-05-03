<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'ride_id' => 'required|exists:rides,id',
            'start_terminal_id' => 'required|exists:terminals,id',
            'end_terminal_id' => 'required|exists:terminals,id',
            'travel_date' => 'required|after:'.$today,
            'pax' => 'nullable|numeric|min:1'
        ];
    }

    public function messages()
    {
        return [

            'pax.max' => 'Maximum of :max person is only available',
        ];
    }
}
