<?php

namespace Tests\Feature\Admin\Clients;

use App\Client;
use App\User;
use Tests\TestCase;
use App\Exports\ClientsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExcelClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_download_clients_export()
    {
        $clients = factory(Client::class, 10)->create();
        $user = factory(User::class)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('clients.index', ['format' => 'xlsx']));

        Excel::assertDownloaded('clients-list.xlsx', function (ClientsExport $export) use ($clients) {
            return $export->collection()->contains($clients->random());
        });
    }
}
