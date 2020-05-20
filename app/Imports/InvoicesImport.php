<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Entities\User;
use App\Entities\Invoice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class InvoicesImport extends BaseImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    WithBatchInserts
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
            'created_by' => $row['ID Vendedor'],
            'updated_by' => $row['ID Vendedor'],
        ]);
    }

    public function rules(): array
    {
        return [
            'Fecha de expedición' => 'required|date',
            'Fecha de vencimiento' => 'nullable|date|after:issued_at',
            'Fecha de recibo' => 'nullable|date|after:issued_at|before:expires_at',
            'Descripción' => 'nullable|string|max:255',
            'ID Cliente' => 'required|numeric|exists:clients,id',
            'ID Vendedor' => ['required', 'numeric',
                function ($attribute, $userId, $onFailure) {
                    if (auth()->user()->can('Import all invoices')
                        || auth()->user()->hasRole('SuperAdmin')) {
                        if (User::where('id', $userId)->count() == 0) {
                            $onFailure("Este vendedor no existe");
                        }
                    } elseif (auth()->user()->can('Import invoices')) {
                        if ($userId != auth()->id()) {
                            $onFailure("No tiene permisos de importar facturas de otros vendedores");
                        }
                    } else {
                        $onFailure("No tiene permisos de importar facturas");
                    }
                }
            ]
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
