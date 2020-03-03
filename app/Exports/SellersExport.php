<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;

class SellersExport implements FromCollection, Responsable, WithHeadings, WithMapping, ShouldQueue
{
    use Exportable;

    private $sellers;

    public function __construct($sellers)
    {
        $this->sellers = $sellers;
    }

    public function collection()
    {
        return $this->sellers;
    }

    public function map($seller): array
    {
        return [
            $seller->type_document->fullname,
            $seller->document,
            $seller->name,
            $seller->surname,
            $seller->email,
            $seller->cell_phone_number,
            $seller->phone_number,
            $seller->address,
            $seller->type_document_id,
        ];
    }

    public function headings(): array
    {
        return [
            'Tipo de documento',
            'Número documento',
            'Nombre',
            'Apellido',
            'Correo electrónico',
            'Teléfono celular',
            'Teléfono fijo',
            'Dirección',
            'ID Documento',
        ];
    }
}
