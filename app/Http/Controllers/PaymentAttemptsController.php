<?php

namespace App\Http\Controllers;

use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;
use App\Invoice;

class PaymentAttemptsController extends Controller
{

    public function create(Invoice $invoice)
    {
        if ($invoice->total == 0){
            return redirect()->route('invoices.show', $invoice)->with('message', __("La factura no tiene productos a pagar, intente nuevamente"));
        }elseif ($invoice->state->name == "Pagada"){
            return redirect()->route('invoices.show', $invoice)->with('message', __("La factura ya se encuentra pagada"));
        }
        return view('invoices.payments.create', compact('invoice'));
    }

    public function store(Invoice $invoice, Request $request)
    {
        $placetopay = new PlacetoPay([
            'login' => '6dd490faf9cb87a9862245da41170ff2',
            'tranKey' => '024h1IlD',
            'url' => 'https://dev.placetopay.com/redirection/',
        ]);
        //Crear el paymentAttempt
        //Crear el modelo y la tabla en la BD
        //
        $request_c = [
            "buyer" => [
                "name" => $invoice->client->name,
                "surname" => $invoice->client->surname,
                "email" => $invoice->client->email,
                "documentType" => $invoice->client->type_document->name,
                "document" => $invoice->client->document,
                "mobile" => $invoice->client->cell_phone_number,
                "address" => [
                    "street" => $invoice->client->address,
                ]
            ],
            'payment' => [
                'reference' => $invoice->id,
                'description' => $invoice->description,
                'amount' => [
                    'currency' => 'COP',
                    'total' => $invoice->total,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'ipAddress' => $request->ip(),
            'userAgent' => $request->header('User-Agent'),
            'returnUrl' => route('invoices.payments.show', $invoice),
        ];
        $response = $placetopay->request($request_c);
        if ($response->isSuccessful()) {
            // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
            // Redirect the client to the processUrl or display it on the JS extension
            return redirect()->away($response->processUrl());
        } else {
            // There was some error so check the message and log it
            dd($response->status()->message());
        }
    }

    public function show()
    {
    }
}
