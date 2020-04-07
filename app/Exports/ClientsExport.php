<?php

namespace App\Exports;

use App\Entities\Client;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Actions\Clients\GetClientsAction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue
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
        return (new GetClientsAction)->execute(new Client(), array_merge($this->filters, [
            'authUser' => $this->authUser
        ]));
    }

    public function map($client): array
    {
        return [
            $client->type_document->fullname,
            $client->document,
            $client->name,
            $client->surname,
            $client->email,
            $client->cellphone,
            $client->phone,
            $client->address,
            $client->creator->fullname,
            $client->type_document_id,
            $client->creator->id,
        ];
    }

    public function headings(): array
    {
        return [
            'Tipo de documento',
            'Número documento',
            'Nombre',
            'Apellidos',
            'Correo electrónico',
            'Teléfono celular',
            'Teléfono fijo',
            'Dirección',
            'Creado por',
            'ID Documento',
            'ID Creador',
        ];
    }
}
