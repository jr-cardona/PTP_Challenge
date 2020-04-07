<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        DB::table('roles')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        Role::create(['name' => 'SuperAdmin']);

        Role::create(['name' => 'Admin'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'Seller'])
            ->givePermissionTo('invoices.list.associated')
            ->givePermissionTo('invoices.create')
            ->givePermissionTo('invoices.edit.associated')
            ->givePermissionTo('invoices.import.associated')
            ->givePermissionTo('invoices.export.all')
            ->givePermissionTo('clients.list.all')
            ->givePermissionTo('clients.create')
            ->givePermissionTo('clients.edit.associated')
            ->givePermissionTo('clients.delete.associated')
            ->givePermissionTo('clients.export.all')
            ->givePermissionTo('clients.import.associated')
            ->givePermissionTo('users.view.profile')
            ->givePermissionTo('users.edit.profile')
            ->givePermissionTo('reports.list.associated')
            ->givePermissionTo('reports.download.associated');

        Role::create(['name' => 'Client'])
            ->givePermissionTo('invoices.list.associated')
            ->givePermissionTo('invoices.pay.associated')
            ->givePermissionTo('invoices.receive.associated')
            ->givePermissionTo('users.view.profile')
            ->givePermissionTo('users.edit.profile');

        Role::create(['name' => 'Accountant'])
            ->givePermissionTo('invoices.list.all')
            ->givePermissionTo('invoices.export.all')
            ->givePermissionTo('reports.general.list.all')
            ->givePermissionTo('reports.general.export')
            ->givePermissionTo('users.view.profile')
            ->givePermissionTo('users.edit.profile');

        Role::create(['name' => 'Stock'])
            ->givePermissionTo('products.list.all')
            ->givePermissionTo('products.create')
            ->givePermissionTo('products.edit.all')
            ->givePermissionTo('products.delete.all')
            ->givePermissionTo('products.export.all')
            ->givePermissionTo('products.import.all')
            ->givePermissionTo('users.view.profile')
            ->givePermissionTo('users.edit.profile');
    }
}
