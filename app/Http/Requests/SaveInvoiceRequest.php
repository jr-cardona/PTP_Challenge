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
            'overdued_at' => 'required|date',
            'received_at' => 'nullable|date',
            'vat' => 'required|numeric',
            'status' => 'required',
            'client_id' => 'required',
            'description' => 'max:255'
        ];
    }
}
