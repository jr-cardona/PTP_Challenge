<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveInvoiceDetailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'invoice_id' => 'required',
            'product_id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric'
        ];
    }
}
