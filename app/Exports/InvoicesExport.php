<?php

namespace App\Exports;

use Config;
use App\Entities\Invoice;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Actions\Invoices\GetInvoicesAction;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoicesExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue
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
        return (new GetInvoicesAction)->execute(new Invoice(), array_merge($this->filters, [
            'authUser' => $this->authUser
        ]));
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
            $invoice->seller->name,
            $invoice->client_id,
            $invoice->created_by,
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
