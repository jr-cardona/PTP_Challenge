<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\SaveProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        return view('products.create', [
            'product' => new Product
        ]);
    }

    public function store(SaveProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index')->with('message', 'Producto creado satisfactoriamente');
    }

    public function show(Product $product)
    {
        return view('products.show', [
            'product' => $product
        ]);
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product
        ]);
    }

    public function update(SaveProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.show', $product)->with('message', 'Producto actualizado satisfactoriamente');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('message', 'Producto eliminado satisfactoriamente');
    }
}
