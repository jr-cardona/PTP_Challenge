<?php

namespace Tests\Feature\Admin\Products\Concerns;

use Illuminate\Support\Str;

trait ProductTestHasProviders
{
    /**
     * An array with basic client data
     *
     * @var array
     */
    protected $baseData = [];

    public function __construct()
    {
        $this->baseData = [
            'name' => 'Test Name',
            'unit_price' => 1000,
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
            'name field is null' => [
                array_replace_recursive($this->baseData, ['name' => null]),
                'name',
                'El campo nombre es obligatorio.'
            ],
            'name field is not a string' => [
                array_replace_recursive($this->baseData, ['name' => 1]),
                'name',
                'El campo nombre debe ser una cadena de caracteres.'
            ],
            'name field is too short' => [
                array_replace_recursive($this->baseData, ['name' => 'NN']),
                'name',
                'El campo nombre debe contener al menos 3 caracteres.'
            ],
            'name field is too long' => [
                array_replace_recursive($this->baseData, ['name' => Str::random(31)]),
                'name',
                'nombre no debe ser mayor que 30 caracteres.'
            ],
            'unit_price field is null' => [
                array_replace_recursive($this->baseData, ['unit_price' => null]),
                'unit_price',
                'El campo precio unitario es obligatorio.'
            ],
            'unit_price field is not numeric' => [
                array_replace_recursive($this->baseData, ['unit_price' => 'Invalid numeric test']),
                'unit_price',
                'precio unitario debe ser numérico.'
            ],
            'unit_price field is too low' => [
                array_replace_recursive($this->baseData, ['unit_price' => 0]),
                'unit_price',
                'El tamaño de precio unitario debe ser de al menos 1.'
            ],
            'unit_price field is too high' => [
                array_replace_recursive($this->baseData, ['unit_price' => 10000000]),
                'unit_price',
                'precio unitario no debe ser mayor a 9999999.'
            ],
            'description field is not a string' => [
                array_replace_recursive($this->baseData, ['description' => 1]),
                'description',
                'El campo descripción debe ser una cadena de caracteres.'
            ],
            'description field is too long' => [
                array_replace_recursive($this->baseData, ['description' => Str::random(256)]),
                'description',
                'descripción no debe ser mayor que 255 caracteres.'
            ],
        ];
    }
}
