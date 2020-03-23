<?php

namespace Tests\Feature\Admin\InvoiceProducts\Concerns;

use App\Entities\Product;
use Illuminate\Support\Str;

trait InvoiceProductTestHasProviders
{
    /**
     * An array with basic client data
     *
     * @var array
     */
    protected $baseData = [];

    public function __construct()
    {
        factory(Product::class)->create();
        $this->baseData = [
            'product_id' => Product::first()->id,
            'quantity' => 1,
        ];
    }

    /**
     * Data provider for store validations test
     *
     * @return array
     */
    public function storeTestDataProvider(): array
    {
        return [
            'product_id field is null' => [
                array_replace_recursive($this->baseData, ['product_id' => null]),
                'product_id',
                'El campo producto es obligatorio.'
            ],
            'product_id field is not numeric' => [
                array_replace_recursive($this->baseData, ['product_id' => 'Invalid numeric test']),
                'product_id',
                'producto debe ser numérico.'
            ],
            'product_id field not exists' => [
                array_replace_recursive($this->baseData, ['product_id' => -1]),
                'product_id',
                'producto es inválido.'
            ],
            'product_id is repeated' => [
                $this->baseData,
                'product_id',
                '¡Este producto ya se encuentra registrado en la factura!'
            ],
            'quantity field is null' => [
                array_replace_recursive($this->baseData, ['quantity' => null]),
                'quantity',
                'El campo cantidad es obligatorio.'
            ],
            'quantity field is not numeric' => [
                array_replace_recursive($this->baseData, ['quantity' => 'Invalid numeric test']),
                'quantity',
                'cantidad debe ser numérico.'
            ],
            'quantity field is too low' => [
                array_replace_recursive($this->baseData, ['quantity' => 0]),
                'quantity',
                'El tamaño de cantidad debe ser de al menos 1.'
            ],
            'quantity field is too high' => [
                array_replace_recursive($this->baseData, ['quantity' => 10000]),
                'quantity',
                'cantidad no debe ser mayor a 9999.'
            ],
        ];
    }
}
