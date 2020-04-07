<?php

namespace Tests\Feature\Admin\Invoices;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Invoice;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_export_invoices()
    {
        factory(Invoice::class, 5)->create();
        Excel::fake();

        $this->get(route('invoices.export', ['extension' => 'xlsx']))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_export_invoices()
    {
        $user = factory(User::class)->create();
        factory(Invoice::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('invoices.export', ['extension' => 'xlsx']))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_export_invoices()
    {
        $permission = Permission::create(['name' => 'Export all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoices = factory(Invoice::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->from(route('invoices.index'))
            ->get(route('invoices.export', ['extension' => 'xlsx']))
            ->assertRedirect(route('invoices.index'));

        Excel::matchByRegex();
        Excel::assertQueued(
            '/invoices_\d{4}\-\d{2}\-\d{2}\_\d{2}\-\d{2}\-\d{2}\.xlsx/',
            function (InvoicesExport $export) use ($invoices) {
                return $export->query()->get()->contains($invoices->random());
            }
        );
    }
}
