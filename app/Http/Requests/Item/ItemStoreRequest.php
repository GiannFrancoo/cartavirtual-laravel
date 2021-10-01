<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
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
            "name" => ["required", "string", "max:250", "unique:items,name"],
            "description" => ["required", "string", "max:250"],
            "price" => ["required", "numeric"],
            "stock" => ["required", "integer"],
            "category_id" => ["required", "integer", "exists:categories,id"],
            "image" => ["sometimes", "nullable", "image", "mimes:jgp,jpeg", "max:10240"],
        ];
    }
}
