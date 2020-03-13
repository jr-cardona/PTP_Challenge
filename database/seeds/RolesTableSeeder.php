<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Admin']);

        Role::create(['name' => 'Seller'])
            ->givePermissionTo('View invoices')
            ->givePermissionTo('Create invoices')
            ->givePermissionTo('Edit invoices')
            ->givePermissionTo('Import invoices')
            ->givePermissionTo('Export invoices')
            ->givePermissionTo('View any clients')
            ->givePermissionTo('Create clients')
            ->givePermissionTo('Edit clients')
            ->givePermissionTo('Delete clients')
            ->givePermissionTo('Export clients')
            ->givePermissionTo('Import clients')
            ->givePermissionTo('View user')
            ->givePermissionTo('Edit user');

        Role::create(['name' => 'Client'])
            ->givePermissionTo('View invoices')
            ->givePermissionTo('Pay invoices')
            ->givePermissionTo('Receive invoices');

        Role::create(['name' => 'Accountant'])
            ->givePermissionTo('View any invoices')
            ->givePermissionTo('Export invoices')
            ->givePermissionTo('View reports')
            ->givePermissionTo('Export reports')
            ->givePermissionTo('View user')
            ->givePermissionTo('Edit user');

        Role::create(['name' => 'Stock'])
            ->givePermissionTo('View any products')
            ->givePermissionTo('Create products')
            ->givePermissionTo('Edit any products')
            ->givePermissionTo('Delete any products')
            ->givePermissionTo('Export products')
            ->givePermissionTo('Import any products')
            ->givePermissionTo('View user')
            ->givePermissionTo('Edit user');
    }
}
