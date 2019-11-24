<?php

use Illuminate\Database\Seeder;
use App\TypeDocument;

class TypeDocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeDocument::create([
            'name' => 'CC',
            'fullname' => 'Cédula de ciudadanía'
        ]);
        TypeDocument::create([
            'name' => 'TI',
            'fullname' => 'Tarjeta de identidad'
        ]);
        TypeDocument::create([
            'name' => 'TP',
            'fullname' => 'Tarjeta de pasaporte'
        ]);
        TypeDocument::create([
            'name' => 'CE',
            'fullname' => 'Cédula de extranjería'
        ]);
    }
}
