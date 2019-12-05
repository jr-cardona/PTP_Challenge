<?php

namespace App\Imports;

use App\Invoice;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');

class InvoicesImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts
{
    use Importable;

    public function model(array $row)
    {
        return new Invoice([
            'number' => $row['Número'],
            'issued_at' => $row['Fecha de expedición'],
            'overdued_at' => $row['Fecha de vencimiento'],
            'received_at' => $row['Fecha de recibo'],
            'vat' => $row['IVA'],
            'description' => $row['Descripción'],
            'state_id' => $row['Estado'],
            'client_id' => $row['Cliente'],
            'seller_id' => $row['Vendedor'],
        ]);
    }

    public function rules(): array{
        return[
            'Fecha de expedición' => 'required|date',
            'Fecha de vencimiento' => 'required|date|after:issued_at',
            'Fecha de recibo' => 'nullable|date|after:issued_at|before:overdued_at',
            'IVA' => 'required|numeric|between:0,100',
            'Descripción' => 'nullable|string|max:255',
            'Estado' => 'required|numeric|exists:states,id',
            'Cliente' => 'required|numeric|exists:clients,id',
            'Vendedor' => 'required|numeric|exists:sellers,id',
            'Número' => ['required', Rule::unique('invoices', 'number')],
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
