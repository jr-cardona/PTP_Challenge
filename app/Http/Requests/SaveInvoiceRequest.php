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
            'number' => 'required|numeric',
            'expedition_date' => 'required|date',
            'due_date' => 'required|date',
            'invoice_date' => 'required|date',
            'vat' => 'required|numeric',
            'total' => 'required|numeric',
            'status' => 'required',
            'client_id' => 'required',
        ];
    }
}
