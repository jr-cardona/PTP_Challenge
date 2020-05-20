<?php

namespace App\Actions\Products;

use App\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class StoreProductsAction extends Action
{
    public function action(Model $product, array $request): Model
    {
        return $product->create($request);
    }
}
