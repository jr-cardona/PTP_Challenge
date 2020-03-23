<?php


namespace App\Actions\Products;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class UpdateProductsAction extends Action
{
    public function action(Model $invoice, Request $request): Model
    {
        $invoice->update($request->validated());
        return $invoice;
    }
}
