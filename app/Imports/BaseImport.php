<?php


namespace App\Imports;

use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class BaseImport implements WithEvents
{
    use RegistersEventListeners;
    public static function beforeImport(BeforeImport $event)
    {
        $worksheet = $event->reader->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        if ($highestRow < 2) {
            $error = \Illuminate\Validation\ValidationException::withMessages([]);
            $failure = new Failure(1, 'Rows', [0 => 'El archivo se encuentra vacío']);
            $failures = [0 => $failure];
            throw new ValidationException($error, $failures);
        }
    }
}
