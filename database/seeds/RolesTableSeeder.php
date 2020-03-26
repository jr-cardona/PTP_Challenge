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
            ->givePermissionTo('View invoices')
            ->givePermissionTo('Create invoices')
            ->givePermissionTo('Edit invoices')
            ->givePermissionTo('Import invoices')
            ->givePermissionTo('Export all invoices')
            ->givePermissionTo('View all clients')
            ->givePermissionTo('Create clients')
            ->givePermissionTo('Edit clients')
            ->givePermissionTo('Delete clients')
            ->givePermissionTo('Export all clients')
            ->givePermissionTo('Import clients')
            ->givePermissionTo('View profile')
            ->givePermissionTo('Edit profile');

        Role::create(['name' => 'Client'])
            ->givePermissionTo('View invoices')
            ->givePermissionTo('Pay invoices')
            ->givePermissionTo('Receive invoices')
            ->givePermissionTo('View profile')
            ->givePermissionTo('Edit profile');

        Role::create(['name' => 'Accountant'])
            ->givePermissionTo('View all invoices')
            ->givePermissionTo('Export all invoices')
            ->givePermissionTo('View all reports')
            ->givePermissionTo('Export reports')
            ->givePermissionTo('View profile')
            ->givePermissionTo('Edit profile');

        Role::create(['name' => 'Stock'])
            ->givePermissionTo('View all products')
            ->givePermissionTo('Create products')
            ->givePermissionTo('Edit all products')
            ->givePermissionTo('Delete all products')
            ->givePermissionTo('Export all products')
            ->givePermissionTo('Import all products')
            ->givePermissionTo('View profile')
            ->givePermissionTo('Edit profile');
    }
}
