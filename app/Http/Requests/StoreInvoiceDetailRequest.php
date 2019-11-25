<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceDetailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|numeric|exists:products,id',
            'quantity' => 'required|numeric|min:1|max:9999',
            'unit_price' => 'required|numeric|min:50|max:999999999.99',
        ];
    }
}
