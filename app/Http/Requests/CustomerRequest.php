<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

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
        return [
            'customer_type_id' => 'required',
            'name' => 'required',
            'code' => 'required',
            'responsable_name' => 'required',
            //'responsable_last_name1' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'cp' => 'required',
            'asentamiento' => 'required',
            'municipio' => 'required',
            'estado' => 'required',
            'calle_numero' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'customer_type_id.required' => 'Debe especificar un tipo de cliente.',
            'name.required' => 'El nombre del cliente es requerido.',
            'code.required' => 'Ingrese un identificador para este cliente',
            'responsable_name.required' => 'Ingrese el nombre de la persona responsable',
            'responsable_last_name1.required' => 'Ingrese el apellido paterno de la persona responsable',
            'phone.required' => 'El número de teléfono es requerido',
            'phone.numeric' => 'El número no tiene un formato válido',
            'email.required' => 'Ingrese un email de contacto para este cliente',
            'email.email' => 'El email no tiene el formato requerido',
            'cp.required' => 'Este campo es obligatorio',
            'asentamiento.required' => 'Este campo es obligatorio',
            'municipio.required' => 'Este campo es obligatorio',
            'estado.required' => 'Este campo es obligatorio',
            'calle_numero.required' => 'Este campo es obligatorio',
        ];
    }
}
