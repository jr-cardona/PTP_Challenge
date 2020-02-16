<?php

namespace Tests\Feature\Admin\Clients;

use App\User;
use Tests\TestCase;
use App\Exports\ClientsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExcelClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_download_clients_export()
    {
        $user = factory(User::class)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('export.clients'));

        Excel::assertDownloaded('clients-list.xlsx', function(ClientsExport $export) {
            return $export->view()->name() == 'exports.clients';
        });
    }
}
