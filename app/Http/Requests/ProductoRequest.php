<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'equipo_refaccion' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'serie' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'equipo_refaccion.required' => 'Este campo es obligatorio',
            'marca.required' => 'Este campo es obligatorio',
            'modelo.required' => 'Este campo es obligatorio',
            'serie.required' => 'Este campo es obligatorio'
        ];
    }
}
