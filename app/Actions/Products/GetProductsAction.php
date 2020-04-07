<?php

namespace App\Actions\Products;

use App\Actions\Action;
use App\Entities\Product;
use Illuminate\Database\Eloquent\Model;

class GetProductsAction extends Action
{
    public function action(Model $product, array $request)
    {
        $authUser = auth()->user() ?? $request['authUser'];

        if ($authUser->can('viewAll', Product::class)){
            $product = $product->id($request['id'] ?? '');
        } elseif ($authUser->can('viewAssociated', Product::class)){
            $product = $product->creatorId($authUser);
        }

        return $product->with(['creator', 'invoices'])->orderBy('id');
    }
}
