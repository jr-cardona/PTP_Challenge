<?php

namespace App\Exports;

use App\Entities\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Actions\Products\GetProductsAction;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue
{
    use Exportable;

    protected $filters;
    protected $authUser;

    public function __construct($filters, $authUser)
    {
        $this->filters = $filters;
        $this->authUser = $authUser;
    }

    public function query()
    {
        return (new GetProductsAction)->execute(new Product(), array_merge($this->filters, [
            'authUser' => $this->authUser
        ]));
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->cost,
            $product->price,
            $product->description,
        ];
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Costo',
            'Precio',
            'Descripción',
        ];
    }
}
