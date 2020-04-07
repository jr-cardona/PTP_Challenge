<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        DB::table('permissions')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $this->command->call('cache:forget', ['key' => 'spatie.permission.cache']);

        Permission::create(['name' => 'invoices.list.all']);
        Permission::create(['name' => 'invoices.list.associated']);
        Permission::create(['name' => 'invoices.print.all']);
        Permission::create(['name' => 'invoices.print.associated']);
        Permission::create(['name' => 'invoices.create']);
        Permission::create(['name' => 'invoices.edit.all']);
        Permission::create(['name' => 'invoices.edit.associated']);
        Permission::create(['name' => 'invoices.annul.all']);
        Permission::create(['name' => 'invoices.annul.associated']);
        Permission::create(['name' => 'invoices.export.all']);
        Permission::create(['name' => 'invoices.import.all']);
        Permission::create(['name' => 'invoices.import.associated']);
        Permission::create(['name' => 'invoices.pay.all']);
        Permission::create(['name' => 'invoices.pay.associated']);
        Permission::create(['name' => 'invoices.receive.all']);
        Permission::create(['name' => 'invoices.receive.associated']);

        Permission::create(['name' => 'clients.list.all']);
        Permission::create(['name' => 'clients.list.associated']);
        Permission::create(['name' => 'clients.create']);
        Permission::create(['name' => 'clients.edit.all']);
        Permission::create(['name' => 'clients.edit.associated']);
        Permission::create(['name' => 'clients.delete.all']);
        Permission::create(['name' => 'clients.delete.associated']);
        Permission::create(['name' => 'clients.export.all']);
        Permission::create(['name' => 'clients.import.all']);
        Permission::create(['name' => 'clients.import.associated']);

        Permission::create(['name' => 'products.list.all']);
        Permission::create(['name' => 'products.list.associated']);
        Permission::create(['name' => 'products.create']);
        Permission::create(['name' => 'products.edit.all']);
        Permission::create(['name' => 'products.edit.associated']);
        Permission::create(['name' => 'products.delete.all']);
        Permission::create(['name' => 'products.delete.associated']);
        Permission::create(['name' => 'products.export.all']);
        Permission::create(['name' => 'products.import.all']);
        Permission::create(['name' => 'products.import.associated']);

        Permission::create(['name' => 'users.list.all']);
        Permission::create(['name' => 'users.view.profile']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.edit.all']);
        Permission::create(['name' => 'users.edit.profile']);
        Permission::create(['name' => 'users.delete.all']);
        Permission::create(['name' => 'users.delete.associated']);
        Permission::create(['name' => 'users.export.all']);
        Permission::create(['name' => 'users.import.all']);
        Permission::create(['name' => 'users.sync.roles']);

        Permission::create(['name' => 'reports.general.list.all']);
        Permission::create(['name' => 'reports.general.export']);
        Permission::create(['name' => 'reports.list.all']);
        Permission::create(['name' => 'reports.list.associated']);
        Permission::create(['name' => 'reports.download.all']);
        Permission::create(['name' => 'reports.download.associated']);
        Permission::create(['name' => 'reports.delete.all']);
        Permission::create(['name' => 'reports.delete.associated']);
    }
}
