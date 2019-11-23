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
            'received_at' => 'nullable|date',
            'vat' => 'required|numeric|between:0,100',
            'status' => 'required',
            'client_id' => 'required|numeric|exists:clients,id',
            'description' => 'max:255'
        ];
    }
}
