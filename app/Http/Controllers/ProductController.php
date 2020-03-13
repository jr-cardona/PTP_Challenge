<?php

namespace App\Http\Controllers;

use Config;
use App\User;
use Exception;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\ProductsExport;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SaveProductRequest;
use Illuminate\Auth\Access\AuthorizationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('index', new Product());

        $products = Product::with(['owner'])
            ->owner()
            ->id($request->get('id'))
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
     * @return Response
     * @throws AuthorizationException
     */
    public function create(Product $product)
    {
        $this->authorize('create', $product);

        return response()->view('products.create', [
            'product' => new $product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaveProductRequest $request
     * @param Product $product
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(SaveProductRequest $request, Product $product)
    {
        $this->authorize('create', $product);

        $product->name = $request->input('name');
        $product->cost = $request->input('cost');
        $product->price = $request->input('cost') * 1.10;
        $product->description = $request->input('description');
        $product->owner_id = auth()->user()->id;
        $product->save();

        return redirect()->route('products.show', $product->id)->withSuccess(__('Producto creado satisfactoriamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);

        return response()->view('products.show', [
            'product' => $product,
            'side_effect' => ''
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Product $product)
    {
        $this->authorize('edit', $product);

        return response()->view('products.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaveProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(SaveProductRequest $request, Product $product)
    {
        $this->authorize('edit', $product);

        $product->name = $request->input('name');
        $product->cost = $request->input('cost');
        $product->price = $request->input('cost') * 1.10;
        $product->description = $request->input('description');
        $product->save();

        return redirect()->route('products.show', $product)->withSuccess(__('Producto actualizado satisfactoriamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        if ($product->invoices->count() > 0){
            return redirect()->back()->withError(__('No se puede eliminar, hay facturas asociadas con este producto'));
        } else{
            $product->delete();
            return redirect()->route('products.index')->withSuccess(__('Producto eliminado satisfactoriamente'));
        }
    }
}
