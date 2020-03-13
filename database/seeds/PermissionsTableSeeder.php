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
        Permission::create(['name' => 'View any invoices']);
        Permission::create(['name' => 'View invoices']);
        Permission::create(['name' => 'Create invoices']);
        Permission::create(['name' => 'Edit any invoices']);
        Permission::create(['name' => 'Edit invoices']);
        Permission::create(['name' => 'Annul any invoices']);
        Permission::create(['name' => 'Annul invoices']);
        Permission::create(['name' => 'Export invoices']);
        Permission::create(['name' => 'Import any invoices']);
        Permission::create(['name' => 'Import invoices']);
        Permission::create(['name' => 'Pay invoices']);
        Permission::create(['name' => 'Receive invoices']);

        Permission::create(['name' => 'View any clients']);
        Permission::create(['name' => 'Create clients']);
        Permission::create(['name' => 'Edit any clients']);
        Permission::create(['name' => 'Edit clients']);
        Permission::create(['name' => 'Delete any clients']);
        Permission::create(['name' => 'Delete clients']);
        Permission::create(['name' => 'Export clients']);
        Permission::create(['name' => 'Import any clients']);
        Permission::create(['name' => 'Import clients']);

        Permission::create(['name' => 'View any products']);
        Permission::create(['name' => 'Create products']);
        Permission::create(['name' => 'Edit any products']);
        Permission::create(['name' => 'Delete any products']);
        Permission::create(['name' => 'Export products']);
        Permission::create(['name' => 'Import any products']);

        Permission::create(['name' => 'View any user']);
        Permission::create(['name' => 'View user']);
        Permission::create(['name' => 'Create users']);
        Permission::create(['name' => 'Edit any users']);
        Permission::create(['name' => 'Edit user']);
        Permission::create(['name' => 'Delete any users']);
        Permission::create(['name' => 'Delete user']);

        Permission::create(['name' => 'View reports']);
        Permission::create(['name' => 'Export reports']);
    }
}
