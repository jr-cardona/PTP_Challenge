<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'issued_at' => 'required|date',
            'overdued_at' => 'required|date|after:issued_at',
            'received_at' => 'nullable|date|after:issued_at|before:overdued_at',
            'vat' => 'required|numeric|between:0,100',
            'state_id' => 'required|numeric|exists:states,id',
            'client_id' => 'required|numeric|exists:clients,id',
            'seller_id' => 'required|numeric|exists:sellers,id',
            'description' => 'nullable|string|max:255'
        ];
    }
}
