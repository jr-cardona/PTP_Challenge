<?php

namespace App\Imports;

use App\Invoice;
use Carbon\Carbon;
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
            'issued_at' => Carbon::create($row['Fecha de expedición']),
            'expired_at' => Carbon::create($row['Fecha de vencimiento']),
            'received_at' => Carbon::create($row['Fecha de recibo']),
            'vat' => $row['IVA'],
            'description' => $row['Descripción'],
            'state_id' => $row['ID Estado'],
            'client_id' => $row['ID Cliente'],
            'seller_id' => $row['ID Vendedor'],
        ]);
    }

    public function rules(): array{
        return[
            'Fecha de expedición' => 'required|date',
            'Fecha de vencimiento' => 'nullable|date|after:issued_at',
            'Fecha de recibo' => 'nullable|date|after:issued_at|before:expired_at',
            'IVA' => 'required|numeric|between:0,100',
            'Descripción' => 'nullable|string|max:255',
            'ID Estado' => 'required|numeric|exists:states,id',
            'ID Cliente' => 'required|numeric|exists:clients,id',
            'ID Vendedor' => 'required|numeric|exists:sellers,id',
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
