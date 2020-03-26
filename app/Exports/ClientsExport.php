<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientsExport implements FromCollection, Responsable, WithHeadings, WithMapping, ShouldQueue
{
    use Exportable;

    private $clients;

    public function __construct($clients)
    {
        $this->clients = $clients;
    }

    public function collection()
    {
        return $this->clients;
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
