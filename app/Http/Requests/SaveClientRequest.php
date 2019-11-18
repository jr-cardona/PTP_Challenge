<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sic_code' => 'required|numeric|min:8',
            'type_document' => 'required',
            'name' => 'required|string|max:100',
            'phone_number' => 'numeric|digits:7|nullable',
            'cell_phone_number' => 'numeric|required|digits:10',
            'address' => 'required',
            'email' => 'required|email|string|max:100',
        ];
    }
}
