<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //Validar si es admin o gerente
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
            'service_type_id' => 'required',
            'final_user_id' => 'required',
            'customer_id' => 'required',
            'technical_id' => 'required',
            'schedule_fecha' => 'required',
            'schedule_hora' => 'required',
            'description' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'service_type_id.required' => 'Debe seleccionar un tipo de servicio',
            'final_user_id.required' => 'Debe seleccionar un usuario final',
            'customer_id.required' => 'Debe seleccionar un cliente para este servicio',
            'technical_id.required' => 'Debe asignar un técnico a este servicio',
            'schedule_fecha.required' => 'Especifique la fecha de la cita',
            'schedule_hora.required' => 'Especifique la hora de la cita',
            'description.required' => 'Debe describir describir la problemática del servicio'
        ];
    }
}
