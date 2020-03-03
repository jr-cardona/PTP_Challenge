<?php

namespace App\Exports;

use Config;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection, Responsable, WithHeadings, WithMapping, ShouldQueue
{
    use Exportable;

    private $invoices;

    public function __construct($invoices)
    {
        $this->invoices = $invoices;
    }

    public function collection()
    {
        return $this->invoices;
    }

    public function map($invoice): array
    {
        return [
            $invoice->fullname,
            $invoice->state,
            $invoice->created_at,
            $invoice->updated_at,
            $invoice->issued_at->toDateString(),
            $invoice->expires_at->toDateString(),
            $invoice->received_at,
            Config::get('constants.vat'),
            $invoice->total,
            $invoice->description,
            $invoice->client->fullname,
            $invoice->seller->fullname,
            $invoice->client_id,
            $invoice->seller_id,
        ];
    }

    public function headings(): array
    {
        return [
            'Título',
            'Estado',
            'Fecha de creación',
            'Fecha de modificación',
            'Fecha de expedición',
            'Fecha de vencimiento',
            'Fecha de recibo',
            'IVA',
            'Total',
            'Descripción',
            'Cliente',
            'Vendedor',
            'ID Cliente',
            'ID Vendedor',
        ];
    }
}
