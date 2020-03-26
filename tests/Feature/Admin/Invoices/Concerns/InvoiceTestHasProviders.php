<?php

namespace Tests\Feature\Admin\Invoices\Concerns;

use Carbon\Carbon;
use App\Entities\Client;
use Illuminate\Support\Str;

trait InvoiceTestHasProviders
{
    /**
     * An array with basic client data
     *
     * @var array
     */
    protected $baseData = [];

    public function __construct()
    {
        $client = factory(Client::class)->create();
        $this->baseData = [
            'issued_at' => Carbon::now()->toDateString(),
            'client_id' => $client->id,
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
            'issued_at field is null' => [
                array_replace_recursive($this->baseData, ['issued_at' => null]),
                'issued_at',
                'El campo fecha de expedición es obligatorio.'
            ],
            'issued_at field is not a valid date' => [
                array_replace_recursive($this->baseData, ['issued_at' => 'Invalid date test']),
                'issued_at',
                'fecha de expedición no es una fecha válida.'
            ],
            'issued_at field is too old' => [
                array_replace_recursive($this->baseData, ['issued_at' => Carbon::now()->subMonth()]),
                'issued_at',
                'fecha de expedición debe ser una fecha posterior o igual a '.Carbon::now()->subWeek()->toDateString().'.'
            ],
            'issued_at field is too newest' => [
                array_replace_recursive($this->baseData, ['issued_at' => Carbon::now()->addDay()]),
                'issued_at',
                'fecha de expedición debe ser una fecha anterior o igual a '.Carbon::now()->toDateString().'.'
            ],
            'client_id field is null' => [
                array_replace_recursive($this->baseData, ['client_id' => null]),
                'client_id',
                'El campo cliente es obligatorio.'
            ],
            'client_id field is not numeric' => [
                array_replace_recursive($this->baseData, ['client_id' => 'Invalid numeric test']),
                'client_id',
                'cliente debe ser numérico.'
            ],
            'client_id field not exists' => [
                array_replace_recursive($this->baseData, ['client_id' => -1]),
                'client_id',
                'cliente es inválido.'
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
