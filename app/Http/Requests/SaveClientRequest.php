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
                'digits_between:8,10',
                Rule::unique('clients')->ignore($this->route('client'))
            ],
            'type_document_id' => 'required|numeric|exists:type_documents,id',
            'name' => 'required|string|min:3|max:50',
            'phone_number' => 'nullable|numeric|digits:7',
            'cell_phone_number' => 'required|numeric|digits:10',
            'address' => 'required|string|min:5|max:50',
            'email' => [
                'required',
                'email',
                'string',
                'min:5',
                'max:100',
                Rule::unique('clients')->ignore($this->route('client'))
            ]
        ];
    }
}
