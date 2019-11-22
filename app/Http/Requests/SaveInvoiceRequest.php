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
<<<<<<< Updated upstream
            'vat' => 'required|numeric',
            'total' => 'required|numeric',
=======
            'vat' => 'required|numeric|between:0,100',
>>>>>>> Stashed changes
            'status' => 'required',
            'client_id' => 'required',
            'description' => 'max:255'
        ];
    }
}
