<?php

namespace App\Http\Controllers;

use Config;
use App\Product;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use App\Http\Requests\SaveProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::id($request->get('id'))
            ->orderBy('id');
        if(! empty($request->get('format'))){
            return (new ProductsExport($products->get()))
                ->download('products-list.'.$request->get('format'));
        } else {
            $paginate = Config::get('constants.paginate');
            $count = $products->count();
            $products = $products->paginate($paginate);

            return response()->view('products.index', [
                'products' => $products,
                'request' => $request,
                'count' => $count,
                'paginate' => $paginate,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('products.create', [
            'product' => new Product()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveProductRequest $request)
    {
        $result = Product::create(array_merge(
            $request->validated(), [
                'price' => $request->get('cost') * 1.10
            ])
        );

        return redirect()->route('products.show', $result->id)->withSuccess(__('Producto creado satisfactoriamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
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
    public function edit(Product $product)
    {
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
    public function update(SaveProductRequest $request, Product $product)
    {
        $product->update(array_merge(
            $request->validated(), [
            'price' => $request->get('cost') * 1.10
        ]));

        return redirect()->route('products.show', $product)->withSuccess(__('Producto actualizado satisfactoriamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        if ($product->invoices->count() > 0){
            return redirect()->back()->withError(__('No se puede eliminar, hay facturas asociadas con este producto'));
        } else{
            $product->delete();
            return redirect()->route('products.index')->withSuccess(__('Producto eliminado satisfactoriamente'));
        }
    }
}
