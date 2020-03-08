<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SaveClientRequest extends FormRequest
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
            'document' => [
                'required',
                'numeric',
                'digits_between:8,10',
                Rule::unique('clients')->ignore($this->route('client'))
            ],
            'type_document_id' => 'required|numeric|exists:type_documents,id',
            'name' => 'required|string|min:3|max:50',
            'surname' => 'required|string|min:3|max:50',
            'phone_number' => 'nullable|numeric|digits:7',
            'cellphone' => 'required|numeric|digits:10|starts_with:3',
            'address' => 'required|string|min:5|max:100',
            'email' => [
                'required',
                'string',
                'email',
                'min:6',
                'max:100',
                Rule::unique('clients')->ignore($this->route('client'))
            ]
        ];
    }
}
