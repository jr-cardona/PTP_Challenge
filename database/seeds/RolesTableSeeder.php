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
        Role::create(['name' => 'SuperAdmin']);

        Role::create(['name' => 'Admin'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'Seller'])
            ->givePermissionTo('View invoices')
            ->givePermissionTo('Create invoices')
            ->givePermissionTo('Edit invoices')
            ->givePermissionTo('Import invoices')
            ->givePermissionTo('Export any invoices')
            ->givePermissionTo('View any clients')
            ->givePermissionTo('Create clients')
            ->givePermissionTo('Edit clients')
            ->givePermissionTo('Delete clients')
            ->givePermissionTo('Export any clients')
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
            ->givePermissionTo('View any invoices')
            ->givePermissionTo('Export any invoices')
            ->givePermissionTo('View any reports')
            ->givePermissionTo('Export reports')
            ->givePermissionTo('View profile')
            ->givePermissionTo('Edit profile');

        Role::create(['name' => 'Stock'])
            ->givePermissionTo('View any products')
            ->givePermissionTo('Create products')
            ->givePermissionTo('Edit any products')
            ->givePermissionTo('Delete any products')
            ->givePermissionTo('Export any products')
            ->givePermissionTo('Import any products')
            ->givePermissionTo('View profile')
            ->givePermissionTo('Edit profile');
    }
}
