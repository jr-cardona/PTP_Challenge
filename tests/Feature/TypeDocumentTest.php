<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Entities\Client;
use App\Entities\TypeDocument;
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
}
