<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Employee_Update_Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return true
     */
    public function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:employees,'. $this->id,
            'position' => 'required|string|max:255',
            'salary'   => 'required|numeric|between:0,999999.99',
        ];
    }
}
