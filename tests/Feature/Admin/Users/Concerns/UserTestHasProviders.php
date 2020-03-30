<?php

namespace Tests\Feature\Admin\Users\Concerns;

use Illuminate\Support\Str;

trait UserTestHasProviders
{
    /**
     * An array with basic user data
     *
     * @var array
     */
    protected $baseData = [];

    public function __construct()
    {
        $this->baseData = [
            'name' => 'Test Name',
            'surname' => 'Test Surname',
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
