<?php

use Illuminate\Database\Seeder;
use App\Entities\TypeDocument;

class TypeDocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        DB::table('type_documents')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        TypeDocument::create([
            'name' => 'CC',
            'fullname' => 'Cédula de ciudadanía'
        ]);
        TypeDocument::create([
            'name' => 'NIT',
            'fullname' => 'NIT'
        ]);
        TypeDocument::create([
            'name' => 'TI',
            'fullname' => 'Tarjeta de identidad'
        ]);
        TypeDocument::create([
            'name' => 'PPN',
            'fullname' => 'Pasaporte'
        ]);
        TypeDocument::create([
            'name' => 'CE',
            'fullname' => 'Cédula de extranjería'
        ]);
    }
}
