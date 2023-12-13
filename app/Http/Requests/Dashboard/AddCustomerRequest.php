<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AddCustomerRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'phone1' => 'required|integer',
            'phone2' => 'nullable|integer',
            'address' => 'required|min:10'
        ];
    }
}
