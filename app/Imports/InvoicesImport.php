<?php

namespace App\Imports;

use App\Invoice;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class InvoicesImport extends BaseImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts
{
    use Importable;
    private $rows = 0;

    public function model(array $row)
    {
        ++$this->rows;
        return new Invoice([
            'issued_at' => Carbon::create($row['Fecha de expedición']),
            'expires_at' => Carbon::create($row['Fecha de vencimiento']),
            'received_at' => Carbon::create($row['Fecha de recibo']),
            'description' => $row['Descripción'],
            'client_id' => $row['ID Cliente'],
            'seller_id' => $row['ID Vendedor'],
        ]);
    }

    public function rules(): array
    {
        return[
            'Fecha de expedición' => 'required|date',
            'Fecha de vencimiento' => 'nullable|date|after:issued_at',
            'Fecha de recibo' => 'nullable|date|after:issued_at|before:expires_at',
            'Descripción' => 'nullable|string|max:255',
            'ID Cliente' => 'required|numeric|exists:clients,id',
            'ID Vendedor' => 'required|numeric|exists:sellers,id',
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
