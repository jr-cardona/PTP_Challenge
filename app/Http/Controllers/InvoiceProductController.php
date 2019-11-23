<?php

namespace App\Http\Controllers;

use App\Product;
use App\Invoice;
use Illuminate\Http\Request;

class InvoiceProductController extends Controller
{

    public function create(Invoice $invoice)
    {
        return view('invoices.details.create', [
            'invoice' => $invoice,
            'products' => Product::all()
        ]);
    }

    public function store(Invoice $invoice)
    {
        $invoice->products()->attach(request('product_id'), [
            'quantity' => request('quantity'),
            'unit_price' => request('unit_price'),
            'total_price' => request('quantity') * request('unit_price')
        ]);

        return redirect()->route('invoices.show', $invoice)->with('message', 'Detalle creado satisfactoriamente');
    }

    public function edit(Invoice $invoice, Product $product)
    {
        return view('invoices.details.edit', [
            'invoice' => $invoice,
            'product' => $product
        ]);
    }

    public function update(Invoice $invoice, Product $product)
    {
        $attributes = [
            'quantity' => request('quantity'),
            'unit_price' => request('unit_price'),
            'total_price' => request('quantity') * request('unit_price')
        ];
        $invoice->products()->updateExistingPivot($product->id, $attributes);

        return redirect()->route('invoices.show', $invoice)->with('message', 'Detalle actualizado satisfactoriamente');
    }

    public function destroy($id)
    {
        //
    }
}
