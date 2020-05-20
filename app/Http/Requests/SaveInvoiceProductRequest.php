<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class SaveInvoiceProductRequest extends FormRequest
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
        $rules = [
            'quantity' => 'required|numeric|min:1|max:9999',
        ];
        if ($this->method() == "POST") {
            $rules['product_id'] = ['required', 'numeric', 'exists:products,id'];
        }
        return $rules;
    }

    /**
     * @param $validator
     */
    public function withValidator($validator)
    {
        if ($this->method() == "POST") {
            $validator->after(function ($validator) {
                if ($this->repeatedProduct()) {
                    $validator->errors()->add('product_id', '¡Este producto ya se encuentra registrado en la factura!');
                }
            });
        }
    }

    public function repeatedProduct()
    {
        $invoice_product = DB::table('products as p')
            ->join('invoice_product as ip', 'ip.product_id', '=', 'p.id')
            ->join('invoices as i', 'i.id', '=', 'ip.invoice_id')
            ->where('p.id', $this->product_id)
            ->where('i.id', $this->invoice->id)
            ->get();

        return ($invoice_product->count() > 0);
    }
}
