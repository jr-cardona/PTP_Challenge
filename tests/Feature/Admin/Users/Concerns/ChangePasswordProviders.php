<?php

namespace Tests\Feature\Admin\Users\Concerns;

trait ChangePasswordProviders
{
    /**
     * An array with basic user data
     *
     * @var array
     */
    protected $baseData = [
        'current_password' => 'actualsecret',
        'new_password' => 'newsecret',
        'new_password_confirmation' => 'newsecret',
    ];

    /**
     * Data provider for store validations test
     *
     * @return array
     */
    public function storeTestDataProvider(): array
    {
        return [
            'current_password field is null' => [
                array_replace_recursive($this->baseData, ['current_password' => null]),
                'current_password',
                'El campo contraseña actual es obligatorio.'
            ],
            'current_password field does not matches' => [
                array_replace_recursive($this->baseData, ['current_password' => 'NN']),
                'current_password',
                'Contraseña incorrecta.'
            ],
            'new_password field is null' => [
                array_replace_recursive($this->baseData, ['new_password' => null]),
                'new_password',
                'El campo contraseña nueva es obligatorio.'
            ],
            'new_password field is too short' => [
                array_replace_recursive($this->baseData, ['new_password' => 'Test']),
                'new_password',
                'El campo contraseña nueva debe contener al menos 8 caracteres.'
            ],
            'new_password is not confirmed' => [
                array_replace_recursive($this->baseData, ['new_password' => '12345678']),
                'new_password',
                'La confirmación de contraseña nueva no coincide.'
            ],
            'new_password equals to current_password' => [
                array_replace_recursive($this->baseData, ['new_password' => 'actualsecret']),
                'new_password',
                'Debe ser una contraseña distinta a la actual.'
            ],
        ];
    }
}
