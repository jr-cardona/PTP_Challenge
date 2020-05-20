<?php

namespace App\Exports;

use App\Entities\User;
use App\Actions\Users\GetUsersAction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue
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
        return (new GetUsersAction)->execute(new User(), array_merge($this->filters, [
            'authUser' => $this->authUser
        ]));
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->surname,
            $user->email,
        ];
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Apellidos',
            'Correo electrónico',
        ];
    }
}
