<?php

namespace App\Http\Controllers;

use App\Product;
use App\Invoice;
use App\Http\Requests\SaveInvoiceDetailRequest;
use Illuminate\Support\Facades\DB;

class InvoiceProductController extends Controller
{

    public function create(Invoice $invoice)
    {
        $products = DB::table('products')
            ->whereNotExists(function ($query) use ($invoice) {
                $query->select(DB::raw('invoice_product.id'))
                    ->from('invoice_product')
                    ->whereRaw('invoice_product.product_id = products.id and invoice_product.invoice_id ='.$invoice->id);
            })
            ->get();
        if (isset($products)){
            return view('invoices.details.create', [
                'invoice' => $invoice,
                'products' => $products
            ]);
        }
        else{
            return redirect()->route('invoices.show', $invoice)->with('message', 'No hay productos disponibles para agregar');
        }
    }

    public function store(Invoice $invoice, SaveInvoiceDetailRequest $request)
    {
        $invoice->products()->attach(request('product_id'), $request->validated());

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

    public function destroy(Invoice $invoice, Product $product)
    {
        $invoice->products()->detach($product->id);

        return redirect()->route('invoices.show', $invoice)->with('message', 'Detalle eliminado satisfactoriamente');
    }
}
