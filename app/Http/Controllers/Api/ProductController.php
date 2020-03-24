<?php

namespace App\Http\Controllers\Api;

use App\Entities\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProductRequest;
use App\Actions\Products\GetProductsAction;
use App\Actions\Products\StoreProductsAction;
use App\Actions\Products\UpdateProductsAction;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class);
    }

    public function index(GetProductsAction $action, Request $request)
    {
        $products = $action->execute(new Product(), $request);
        return $products->get();
    }

    public function store(StoreProductsAction $action, SaveProductRequest $request)
    {
        return $action->execute(new Product(), $request);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(UpdateProductsAction $action, Product $product,
                           SaveProductRequest $request)
    {
        $product = $action->execute($product, $request);
        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado correctamente',
        ], 200);
    }
}
