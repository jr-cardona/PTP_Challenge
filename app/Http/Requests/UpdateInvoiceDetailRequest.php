<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceDetailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'quantity' => 'required|numeric|min:1|max:9999',
            'unit_price' => 'required|numeric|min:0.01|max:999999999.99',
        ];
    }
}
