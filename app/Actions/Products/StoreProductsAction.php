<?php


namespace App\Actions\Products;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class StoreProductsAction extends Action
{
    public function action(Model $product, Request $request): Model
    {
        return $product->create($request->validated());
    }
}
