<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,'.$this->employee->user->id,
            'password' => 'nullable|confirmed|min:8',
            'employee_no' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'role' => 'required',
            'contact' => 'required',
            'address' => 'required',
        ];
    }
}
