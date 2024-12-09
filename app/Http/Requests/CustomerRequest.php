<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name'    => 'required',
                    'birthday'    => 'required',
                    'country'    => 'required',
                    'street_address'    => 'required',
                    'password'      => 'required|min:8',
                    'email'         => 'required|email|max:255|unique:users',
                    'phone_number'        => 'required|numeric|unique:users',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'    => 'required',
                    'birthday'    => 'required',
                    'country'    => 'required',
                    'street_address'    => 'required',
                    'password'      => 'nullable|min:8',
                    'email'         => 'required|email|max:255|unique:users,email,'.$this->route()->customer->id,
                    'phone_number'        => 'required|numeric|unique:users,phone_number,'.$this->route()->customer->id,
                ];
            }
            default: break;
        }
    }
}
