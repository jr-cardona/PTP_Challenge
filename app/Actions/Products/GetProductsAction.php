<?php


namespace App\Actions\Products;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class GetProductsAction extends Action
{
    public function action(Model $product, Request $request)
    {
        return $product->with(['creator', 'invoices'])
            ->creator()
            ->id($request->get('id'))
            ->orderBy('id');
    }
}
