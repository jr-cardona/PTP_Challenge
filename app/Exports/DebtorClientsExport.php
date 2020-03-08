<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;

class DebtorClientsExport implements FromCollection, Responsable, WithHeadings, WithMapping, ShouldQueue
{
    use Exportable;

    private $clients;
    private $vat;

    public function __construct($clients, $vat)
    {
        $this->clients = $clients;
        $this->vat = $vat;
    }

    public function collection()
    {
        return $this->clients;
    }

    public function map($client): array
    {
        return [
            $client->id,
            $client->fullname,
            $client->cellphone,
            $client->phone_number,
            $client->address,
            $client->total_due * $this->vat,
        ];
    }

    public function headings(): array
    {
        return [
            'ID Cliente',
            'Nombre completo',
            'Celular',
            'Teléfono fijo',
            'Dirección',
            'Deuda total',
        ];
    }
}
