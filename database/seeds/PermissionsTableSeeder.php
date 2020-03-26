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

        Permission::create(['name' => 'View all invoices']);
        Permission::create(['name' => 'View invoices']);
        Permission::create(['name' => 'Print all invoices']);
        Permission::create(['name' => 'Print invoices']);
        Permission::create(['name' => 'Create invoices']);
        Permission::create(['name' => 'Edit all invoices']);
        Permission::create(['name' => 'Edit invoices']);
        Permission::create(['name' => 'Annul all invoices']);
        Permission::create(['name' => 'Annul invoices']);
        Permission::create(['name' => 'Export all invoices']);
        Permission::create(['name' => 'Import all invoices']);
        Permission::create(['name' => 'Import invoices']);
        Permission::create(['name' => 'Pay invoices']);
        Permission::create(['name' => 'Receive invoices']);

        Permission::create(['name' => 'View all clients']);
        Permission::create(['name' => 'Create clients']);
        Permission::create(['name' => 'Edit all clients']);
        Permission::create(['name' => 'Edit clients']);
        Permission::create(['name' => 'Delete all clients']);
        Permission::create(['name' => 'Delete clients']);
        Permission::create(['name' => 'Export all clients']);
        Permission::create(['name' => 'Import all clients']);
        Permission::create(['name' => 'Import clients']);

        Permission::create(['name' => 'View all products']);
        Permission::create(['name' => 'Create products']);
        Permission::create(['name' => 'Edit all products']);
        Permission::create(['name' => 'Delete all products']);
        Permission::create(['name' => 'Export all products']);
        Permission::create(['name' => 'Import all products']);

        Permission::create(['name' => 'View all users']);
        Permission::create(['name' => 'View profile']);
        Permission::create(['name' => 'Create users']);
        Permission::create(['name' => 'Edit all users']);
        Permission::create(['name' => 'Edit profile']);
        Permission::create(['name' => 'Delete all users']);
        Permission::create(['name' => 'Delete user']);
        Permission::create(['name' => 'Export all users']);
        Permission::create(['name' => 'Import all users']);
        Permission::create(['name' => 'Sync roles']);

        Permission::create(['name' => 'View all reports']);
        Permission::create(['name' => 'Export reports']);
    }
}
