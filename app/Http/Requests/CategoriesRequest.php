<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
            'name'=>[
                'required',
                Rule::unique('cnnxn_categories','name')->ignore($this->id),
            ],
            'main'=>'required',
        ],[
            'name.required'=>'Es necesario que coloques un nombre a la categoria',
            'name.unique'=>'Este nombre ya existe, intentar buscar otro'
        ];
    }
}
