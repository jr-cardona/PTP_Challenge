<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;

class UtilitiesExport implements FromCollection, Responsable, WithHeadings, WithMapping, ShouldQueue
{
    use Exportable;

    private $invoices;
    private $vat;

    public function __construct($invoices, $vat)
    {
        $this->invoices = $invoices;
        $this->vat = $vat;
    }

    public function collection()
    {
        return $this->invoices;
    }

    public function map($invoice): array
    {
        return [
            $invoice->id,
            $invoice->client_fullname,
            $invoice->paid_at,
            $invoice->income * $this->vat,
            $invoice->expenses * $this->vat,
            $invoice->utility * $this->vat,
        ];
    }

    public function headings(): array
    {
        return [
            'Factura',
            'Cliente',
            'Fecha de pago',
            'Ingresos',
            'Egresos',
            'Utilidad',
        ];
    }
}
