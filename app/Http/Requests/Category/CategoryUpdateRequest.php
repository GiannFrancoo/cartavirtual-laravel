<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["required", "string", "max:250", "unique:categories,name,{$this->id},id"],
            "image" => ["sometimes", "nullable", "image", "mimes:jpg,jpeg", "max:10240"],
            "noImage" => ["sometimes", "nullable"],
        ];
    }
}
