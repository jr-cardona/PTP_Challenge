<?php

namespace App\Actions\Products;

use App\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class UpdateProductsAction extends Action
{
    public function action(Model $invoice, array $request): Model
    {
        $invoice->update($request);
        return $invoice;
    }
}
