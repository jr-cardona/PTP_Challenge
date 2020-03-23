<?php

namespace App\Imports;

use App\Entities\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ProductsImport extends BaseImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts
{
    use Importable;
    private $rows = 0;

    public function model(array $row)
    {
        ++$this->rows;
        return new Product([
            'name' => $row['Nombre'],
            'description' => $row['Descripción'],
            'cost' => $row['Costo'],
            'price' => $row['Costo'] * 1.10,
        ]);
    }

    public function rules(): array
    {
        return [
            'Nombre' => 'required',
            'Descripción' => 'required',
            'Costo' => 'required|numeric|min:1|max:9999999',
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
