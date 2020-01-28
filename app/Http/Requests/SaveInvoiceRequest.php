<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveInvoiceRequest extends FormRequest
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
            'issued_at' => 'required|date',
            'vat' => 'required|numeric|between:0,100',
            'client_id' => 'required|numeric|exists:clients,id',
            'seller_id' => 'required|numeric|exists:sellers,id',
            'description' => 'nullable|string|max:255'
        ];
    }
}
