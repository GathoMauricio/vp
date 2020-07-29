<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserPwdRequest extends FormRequest
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
            'password' => 'required|min:6',
            'repassword' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'password.required' => 'La contraseña es requerida.',
            'password.min' => 'La contraseña debe ser almenos de 6 dígitos.',
            'repassword.required' => 'Debe repetir la contraseña'
        ];
    }
}
