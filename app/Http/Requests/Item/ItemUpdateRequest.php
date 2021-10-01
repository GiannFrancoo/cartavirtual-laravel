<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
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
            "name" => ["required", "string", "max:250","unique:items,name,{$this->id},id"],
            "description" => ["required", "string", "max:250"],
            "price" => ["required", "numeric"],
            "stock" => ["required", "integer"],
            "category_id" => ["required", "integer", "exists:categories,id"],
            "image" => ["sometimes", "nullable", "image", "mimes:jpg,jpeg", "max:10240"],
            "noImage" => ["sometimes", "nullable"],
        ];        
    }
}
