<?php

namespace App\Imports;

use App\Entities\User;
use App\Entities\Client;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ClientsImport extends BaseImport implements ToModel, WithHeadingRow,
    WithValidation, WithBatchInserts
{
    use Importable;
    private $rows = 0;

    public function model(array $row)
    {
        ++$this->rows;
        $user = User::create([
            'name' => $row['Nombre'],
            'surname' => $row['Apellidos'],
            'email' => $row['Correo electrónico'],
            'password' => 'secret',
            'created_by' => $row['ID Creador'],
            'updated_by' => $row['ID Creador'],
        ]);
        return new Client([
            'id' => $user->id,
            'type_document_id' => $row['ID Documento'],
            'document' => $row['Número documento'],
            'cellphone' => $row['Teléfono celular'],
            'phone' => $row['Teléfono fijo'],
            'address' => $row['Dirección'],
        ]);
    }

    public function rules(): array
    {
        return [
            'Número documento' => [
                'required',
                'numeric',
                'digits_between:8,10',
                Rule::unique('clients', 'document')
            ],
            'Correo electrónico' => [
                'required',
                'string',
                'email',
                'min:6',
                'max:100',
                'unique:users,email'
            ],
            'ID Documento' => 'required|numeric|exists:type_documents,id',
            'Nombre' => 'required|string|min:3|max:50',
            'Apellidos' => 'required|string|min:3|max:50',
            'Teléfono celular' => 'required|numeric|digits:10',
            'Teléfono fijo' => 'nullable|numeric|digits:7',
            'Dirección' => 'required|string|min:5|max:100',
            'ID Creador' => ['required','numeric',
                function($attribute, $userId, $onFailure){
                    if (auth()->user()->can('Import all clients')
                        || auth()->user()->hasRole('SuperAdmin')){
                        if (User::where('id', $userId)->count() == 0) {
                            $onFailure("Este usuario no existe");
                        }
                    } elseif (auth()->user()->can('Import clients')) {
                        if ($userId != auth()->id()){
                            $onFailure("No tiene permisos de importar clientes de otros usuarios");
                        }
                    } else {
                        $onFailure("No tiene permisos de importar clientes");
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
