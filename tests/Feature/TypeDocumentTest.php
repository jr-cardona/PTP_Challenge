<?php

namespace Tests\Feature;

use App\Client;
use App\Seller;
use Tests\TestCase;
use App\TypeDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeDocumentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_type_document_can_has_many_clients()
    {
        $type_document = factory(TypeDocument::class)->create();
        $clients = factory(Client::class, 3)->create(["type_document_id" => $type_document->id]);

        foreach ($clients as $client) {
            $this->assertDatabaseHas('clients', [
                'id' => $type_document->clients->find($client->id)->id
            ]);
        }
    }

    /** @test */
    public function a_type_document_can_has_many_sellers()
    {
        $type_document = factory(TypeDocument::class)->create();
        $sellers = factory(Seller::class, 3)->create(["type_document_id" => $type_document->id]);

        foreach ($sellers as $seller) {
            $this->assertDatabaseHas('users', [
                'id' => $type_document->sellers->find($seller->id)->id
            ]);
        }
    }
}
