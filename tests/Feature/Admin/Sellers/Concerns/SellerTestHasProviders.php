<?php

namespace Tests\Feature\Admin\Sellers\Concerns;

use App\TypeDocument;
use Illuminate\Support\Str;

trait SellerTestHasProviders
{
    /**
     * An array with basic seller data
     *
     * @var array
     */
    protected $baseData = [];

    public function __construct()
    {
        $type_document = factory(TypeDocument::class)->create();
        $this->baseData = [
            'document' => 0000000000,
            'type_document_id' => $type_document->id,
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => 3000000000,
            'address' => 'Test Address',
            'email' => 'test@test.com',
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
            'document field is null' => [
                array_replace_recursive($this->baseData, ['document' => null]),
                'document',
                'El campo número de documento es obligatorio.'
            ],
            'document field is not numeric' => [
                array_replace_recursive($this->baseData, ['document' => 'Invalid numeric test']),
                'document',
                'número de documento debe ser numérico.'
            ],
            'document field is too short' => [
                array_replace_recursive($this->baseData, ['document' => 0]),
                'document',
                'número de documento debe tener entre 8 y 10 dígitos.'
            ],
            'document field is too long' => [
                array_replace_recursive($this->baseData, ['document' => 00000000000]),
                'document',
                'número de documento debe tener entre 8 y 10 dígitos.'
            ],
            'document field is repeated' => [
                array_replace_recursive($this->baseData, ['document' => 12345678]),
                'document',
                'El campo número de documento ya ha sido registrado.'
            ],
            'type_document_id field is null' => [
                array_replace_recursive($this->baseData, ['type_document_id' => null]),
                'type_document_id',
                'El campo tipo de documento es obligatorio.'
            ],
            'type_document_id field is not numeric' => [
                array_replace_recursive($this->baseData, ['type_document_id' => 'Invalid numeric test']),
                'type_document_id',
                'tipo de documento debe ser numérico.'
            ],
            'type_document_id field not exists' => [
                array_replace_recursive($this->baseData, ['type_document_id' => -1]),
                'type_document_id',
                'tipo de documento es inválido.'
            ],
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
                array_replace_recursive($this->baseData, ['name' => Str::random(51)]),
                'name',
                'nombre no debe ser mayor que 50 caracteres.'
            ],
            'surname field is null' => [
                array_replace_recursive($this->baseData, ['surname' => null]),
                'surname',
                'El campo apellido es obligatorio.'
            ],
            'surname field is not a string' => [
                array_replace_recursive($this->baseData, ['surname' => 1]),
                'surname',
                'El campo apellido debe ser una cadena de caracteres.'
            ],
            'surname field is too short' => [
                array_replace_recursive($this->baseData, ['surname' => 'NN']),
                'surname',
                'El campo apellido debe contener al menos 3 caracteres.'
            ],
            'surname field is too long' => [
                array_replace_recursive($this->baseData, ['surname' => Str::random(51)]),
                'surname',
                'apellido no debe ser mayor que 50 caracteres.'
            ],
            'phone_number field is not numeric' => [
                array_replace_recursive($this->baseData, ['phone_number' => 'Invalid numeric test']),
                'phone_number',
                'número telefónico debe ser numérico.'
            ],
            'phone_number field length is not 7 characters' => [
                array_replace_recursive($this->baseData, ['phone_number' => 123]),
                'phone_number',
                'número telefónico debe tener 7 dígitos.'
            ],
            'cell_phone_number field is null' => [
                array_replace_recursive($this->baseData, ['cell_phone_number' => null]),
                'cell_phone_number',
                'El campo número de celular es obligatorio.'
            ],
            'cell_phone_number field is not numeric' => [
                array_replace_recursive($this->baseData, ['cell_phone_number' => 'Invalid numeric test']),
                'cell_phone_number',
                'número de celular debe ser numérico.'
            ],
            'cell_phone_number field length is not 10 characters' => [
                array_replace_recursive($this->baseData, ['cell_phone_number' => 123]),
                'cell_phone_number',
                'número de celular debe tener 10 dígitos.'
            ],
            'cell_phone_number field not starts with 3' => [
                array_replace_recursive($this->baseData, ['cell_phone_number' => 1234567890]),
                'cell_phone_number',
                'El campo número de celular debe comenzar con uno de los siguientes valores: 3'
            ],
            'address field is null' => [
                array_replace_recursive($this->baseData, ['address' => null]),
                'address',
                'El campo dirección es obligatorio.'
            ],
            'address field is not a string' => [
                array_replace_recursive($this->baseData, ['address' => 1]),
                'address',
                'El campo dirección debe ser una cadena de caracteres.'
            ],
            'address field is too short' => [
                array_replace_recursive($this->baseData, ['address' => 'Test']),
                'address',
                'El campo dirección debe contener al menos 5 caracteres.'
            ],
            'address field is too long' => [
                array_replace_recursive($this->baseData, ['address' => Str::random(101)]),
                'address',
                'dirección no debe ser mayor que 100 caracteres.'
            ],
            'email field is null' => [
                array_replace_recursive($this->baseData, ['email' => null]),
                'email',
                'El campo correo electrónico es obligatorio.'
            ],
            'email field is not a string' => [
                array_replace_recursive($this->baseData, ['email' => 1]),
                'email',
                'El campo correo electrónico debe ser una cadena de caracteres.'
            ],
            'email field is not a valid email' => [
                array_replace_recursive($this->baseData, ['email' => 'Invalid email test']),
                'email',
                'correo electrónico no es un correo válido'
            ],
            'email field is too short' => [
                array_replace_recursive($this->baseData, ['email' => 'a@a.a']),
                'email',
                'El campo correo electrónico debe contener al menos 6 caracteres.'
            ],
            'email field is too long' => [
                array_replace_recursive($this->baseData, ['email' => Str::random(101)]),
                'email',
                'correo electrónico no debe ser mayor que 100 caracteres.'
            ],
            'email field is repeated' => [
                array_replace_recursive($this->baseData, ['email' => "repeated@email.com"]),
                'email',
                'El correo electrónico ya ha sido registrado.'
            ],
        ];
    }
}
