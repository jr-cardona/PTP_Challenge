<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\SaveProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $products = Product::orderBy('id')
            ->product($request->get('product_id'))
            ->paginate(10);
        return response()->view('products.index', [
            'products' => $products,
            'request' => $request,
            'side_effect' => ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return response()->view('products.create', [
            'product' => new Product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveProductRequest $request) {
        $result = Product::create($request->validated());

        return redirect()->route('products.show', $result->id)->with('message', __('Producto creado satisfactoriamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {
        return response()->view('products.show', [
            'product' => $product,
            'side_effect' => ''
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) {
        return response()->view('products.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaveProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SaveProductRequest $request, Product $product) {
        $product->update($request->validated());

        return redirect()->route('products.show', $product)->with('message', __('Producto actualizado satisfactoriamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Product $product) {
        $product->delete();

        return redirect()->route('products.index')->with('message', __('Producto eliminado satisfactoriamente'));
    }

    /**
     * Display the specified resource filtering by name.
     * @param Request $request
     * @return
     */
    public function search(Request $request) {
        $products = Product::where('name', 'like', '%'. $request->name .'%')
            ->orderBy('name')
            ->limit('100')
            ->get();
        return $products;
    }
}
