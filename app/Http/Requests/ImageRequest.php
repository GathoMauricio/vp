<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            "file" => "required|image|mimes:jpg,jpeg,png|max:3000",
            "description" => "required"
        ];
    }
    public function messages()
    {
        return [
            "file.required" => "Debe seleccionar un archivo.",
            "file.image" => "El archivo que intenta subir no parece ser una imagen.",
            "file.mimes" => "El formato de la imagen colo puede ser jpg, jpeg o png.",
            "file.max" => "El máximo del archivo no puede ser de más de 3000 kilobytes.",
            "description.required" => "Debe agregar una descripción a este archivo."
        ];
    }
}
