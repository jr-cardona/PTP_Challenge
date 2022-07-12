<?php

use App\Entities\Client;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            $this->command->call('migrate:fresh');
            $this->command->info("Data cleared, starting from blank database.");
        }

        $this->call([
            TypeDocumentsTableSeeder::class,
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            UsersTableSeeder::class,
        ]);

        $totalClients = (int) $this->command->ask('How many clients do you need ?', 10);
        if ($totalClients > 0) {
            $this->command->info("Creating $totalClients clients...");
            $clients = factory(Client::class, $totalClients)->create();
            $invoicesPerClient = (int) $this->command->ask('How many invoices per client do you need ?', 2);
            if ($invoicesPerClient > 0) {
                $productsPerInvoice = (int) $this->command->ask('How many products per invoice do you need ?', 5);
                $this->customCall(InvoicesTableSeeder::class, [
                    'totalClients' => $totalClients,
                    'clients' => $clients,
                    'totalInvoices' => $invoicesPerClient * $totalClients,
                    'productsPerInvoice' => $productsPerInvoice,
                ]);
            }
        }
    }

    public function customCall($class, $data)
    {
        $seeder = $this->resolve($class);

        if (isset($this->command)) {
            $this->command->getOutput()->writeln("<comment>Seeding:</comment> {$class}");
        }

        $startTime = microtime(true);

        $seeder->run($data);

        $runTime = round(microtime(true) - $startTime, 2);

        if (isset($this->command)) {
            $this->command->getOutput()->writeln("<info>Seeded:</info>  {$class} ({$runTime} seconds)");
        }
    }
}
