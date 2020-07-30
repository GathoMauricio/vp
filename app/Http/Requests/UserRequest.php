<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserRequest extends FormRequest
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
            'roles' => 'required',
            'name' => 'required',
            //'last_name1' => 'required',
            //'last_name2' => 'required',
            'email' => 'required|unique:users|email',
            'phone' => 'required|numeric',
            'cp'=>'required',
            'asentamiento'=>'required',
            'municipio'=>'required',
            'estado'=>'required',
            'calle_numero'=>'required',
            'password' => 'required|min:6',
            'repassword' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'roles.required' => 'Debe especificar por lo menos un rol para este usuario.',
            'name.required' => 'El nombre del usuario es requerido.',
            'last_name1.required' => 'El apellido paterno es requerido.',
            'last_name2.required' => 'El apellido materno es requerido.',
            'email.required' => 'El correo eléctronico es requerido.',
            'email.email' => 'El email no tiene el formato correcto.',
            'email.unique' => 'Este email ya existe en los registros',
            'phone.required' => 'El número de teléfono es requerido',
            'phone.numeric' => 'El número no tiene un formato válido',
            'cp.required'=>'Campo obligatorio',
            'asentamiento.required'=>'Campo obligatorio',
            'municipio.required'=>'Campo obligatorio',
            'estado.required'=>'Campo obligatorio',
            'calle_numero.required'=>'Campo obligatorio',
            'password.required' => 'La contraseña es requerida.',
            'password.min' => 'La contraseña debe ser almenos de 6 dígitos.',
            'repassword.required' => 'Debe repetir la contraseña'
        ];
    }
}
