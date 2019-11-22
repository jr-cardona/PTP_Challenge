<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
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
            'sic_code' => [
                'required',
                'numeric',
                'min:8',
                Rule::unique('clients')->ignore($this->route('client'))
            ],
            'type_document' => 'required',
            'name' => 'required|string|max:50',
            'phone_number' => 'numeric|digits:7|nullable',
            'cell_phone_number' => 'required|numeric||digits:10',
            'address' => 'required|string',
            'email' => [
                'required',
                'email',
                'string',
                'max:100',
                Rule::unique('clients')->ignore($this->route('client'))
            ]
        ];
    }
}
