<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
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
            'data.attributes.title' => '',
            'data.attributes.ingredients.*.data.attributes.name' => '',
            'data.attributes.preparation.text' => '',            
            'data.attributes.preparation.title' => '',            
            'data.attributes.preparation.images.*.url' => '',            
            'data.attributes.presentation.*' => '',
            'data.attributes.conservation' => '',
        ];
    }
}
