<?php

namespace App\Imports;

use App\Entities\User;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class UsersImport extends BaseImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts
{
    use Importable;
    private $rows = 0;

    public function model(array $row)
    {
        ++$this->rows;
        return new User([
            'name' => $row['Nombre'],
            'surname' => $row['Apellidos'],
            'email' => $row['Correo electrónico'],
            'password' => bcrypt('secret'),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'Nombre' => 'required|string|min:3|max:50',
            'Apellidos' => 'required|string|min:3|max:50',
            'Correo electrónico' => [
                'required',
                'email',
                'string',
                'min:5',
                'max:100',
                Rule::unique('users', 'email'),
            ],
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
