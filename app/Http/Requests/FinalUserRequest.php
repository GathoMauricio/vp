<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinalUserRequest extends FormRequest
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
            'customer_id'=>'required',
            'name'=>'required',
            //'last_name1'=>'required',
            //'last_name2'=>'required',
            'email'=>'required|email',
            //'phone'=>'required',
            //'extension'=>'required',
            'area_descripcion'=>'required',
            'cp'=>'required',
            'asentamiento'=>'required',
            'municipio'=>'required',
            'estado'=>'required',
            'calle_numero'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'customer_id.required'=>'Campo obligatorio',
            'name.required'=>'Campo obligatorio',
            'last_name1.required'=>'Campo obligatorio',
            'last_name2.required'=>'Campo obligatorio',
            'email.required'=>'Campo obligatorio',
            'email.email'=>'Ingrese un email válido',
            'phone.required'=>'Campo obligatorio',
            'extension.required'=>'Campo obligatorio',
            'area_descripcion.required'=>'Campo obligatorio',
            'cp.required'=>'Campo obligatorio',
            'asentamiento.required'=>'Campo obligatorio',
            'municipio.required'=>'Campo obligatorio',
            'estado.required'=>'Campo obligatorio',
            'calle_numero.required'=>'Campo obligatorio'
        ];
    }
}
