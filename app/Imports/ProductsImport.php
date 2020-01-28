<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts
{
    use Importable;

    public function model(array $row)
    {
        return new Product([
            'name' => $row['Nombre'],
            'description' => $row['Descripción'],
            'unit_price' => $row['Precio unitario'],
        ]);
    }

    public function rules(): array{
        return[
            'Nombre' => 'required',
            'Descripción' => 'required',
            'Precio unitario' => 'required',
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
