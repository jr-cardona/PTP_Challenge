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
            'cost' => 1000,
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
            'cost field is null' => [
                array_replace_recursive($this->baseData, ['cost' => null]),
                'cost',
                'El campo costo es obligatorio.'
            ],
            'cost field is not numeric' => [
                array_replace_recursive($this->baseData, ['cost' => 'Invalid numeric test']),
                'cost',
                'costo debe ser numérico.'
            ],
            'cost field is too low' => [
                array_replace_recursive($this->baseData, ['cost' => 0]),
                'cost',
                'El tamaño de costo debe ser de al menos 1.'
            ],
            'cost field is too high' => [
                array_replace_recursive($this->baseData, ['cost' => 10000000]),
                'cost',
                'costo no debe ser mayor a 9999999.'
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
