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
            'document' => [
                'required',
                'numeric',
                'digits_between:8,12',
                Rule::unique('clients')->ignore($this->route('client'))
            ],
            'type_document_id' => 'required',
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
