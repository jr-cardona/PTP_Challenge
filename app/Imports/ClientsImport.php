<?php

namespace App\Imports;

use App\User;
use App\Client;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ClientsImport extends BaseImport implements ToCollection, WithHeadingRow, WithBatchInserts
{
    use Importable;
    private $rows = 0;

    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.Número documento' => [
                'required',
                'numeric',
                'digits_between:8,10',
                Rule::unique('clients', 'document')
            ],
            '*.Correo electrónico' => [
                'required',
                'string',
                'email',
                'min:6',
                'max:100',
                'unique:users,email'
            ],
            '*.ID Documento' => 'required|numeric|exists:type_documents,id',
            '*.Nombre' => 'required|string|min:3|max:50',
            '*.Apellido' => 'required|string|min:3|max:50',
            '*.Teléfono celular' => 'required|numeric|digits:10',
            '*.Teléfono fijo' => 'nullable|numeric|digits:7',
            '*.Dirección' => 'required|string|min:5|max:100',
            '*.ID Creador' => ['required','numeric',
                function($attribute, $value, $onFailure){
                    if (auth()->user()->hasPermissionTo('Import any clients')
                        || auth()->user()->hasRole('Admin')){
                        if (User::where('id', $value)->count() == 0) {
                            $onFailure("Este usuario no existe");
                        }
                    } elseif (auth()->user()->hasPermissionTo('Import clients')) {
                        if ($value != auth()->id()){
                            $onFailure("No tiene permisos de importar clientes de otros usuarios");
                        }
                    } else {
                        $onFailure("No tiene permisos de importar clientes");
                    }
                }
            ]
        ])->validate();

        foreach($rows as $row) {
            ++$this->rows;
            $user = User::create([
                'name' => $row['Nombre'],
                'surname' => $row['Apellido'],
                'email' => $row['Correo electrónico'],
                'password' => 'secret',
                'owner_id' => auth()->user()->id
            ]);
            Client::create([
                'user_id' => $user->id,
                'type_document_id' => $row['ID Documento'],
                'document' => $row['Número documento'],
                'cellphone' => $row['Teléfono celular'],
                'phone' => $row['Teléfono fijo'],
                'address' => $row['Dirección'],
            ]);
        }
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
