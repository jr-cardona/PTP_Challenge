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
            'product_id' => 'required',
            'quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'total_price' => ''
        ];
    }
}
