<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:30',
            'description' => 'nullable|string|max:255',
            'unit_price' => 'required|numeric|min:50|max:999999999.99',
        ];
    }
}
