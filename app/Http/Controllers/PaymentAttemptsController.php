<?php

namespace App\Http\Controllers;

use App\Invoice;
use Carbon\Carbon;
use App\PaymentAttempt;
use Illuminate\Http\Request;
use Dnetix\Redirection\PlacetoPay;

class PaymentAttemptsController extends Controller
{

    public function create(Invoice $invoice)
    {
        if ($invoice->total == 0){
            return redirect()->route('invoices.show', $invoice)->withError(__("La factura no tiene productos a pagar, intente nuevamente"));
        }elseif ($invoice->state_id == 2){
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra pagada"));
        }
        return view('invoices.payments.create', compact('invoice'));
    }

    public function store(Invoice $invoice, Request $request, PlacetoPay $placetopay)
    {
        $paymentAttempt = PaymentAttempt::create();
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
            'returnUrl' => route('invoices.payments.show', [$invoice, $paymentAttempt]),
        ];
        $response = $placetopay->request($request_c);
        //dd($response);
        if ($response->isSuccessful()) {
            // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
            $paymentAttempt->update([
                'invoice_id' => $invoice->id,
                'requestID' => $response->requestId(),
                'processUrl' => $response->processUrl(),
                'status' => $response->status()->status(),
            ]);
            // Redirect the client to the processUrl or display it on the JS extension
            return redirect()->away($response->processUrl());
        } else {
            // There was some error so check the message and log it
            dd($response->status()->message());
        }
    }

    public function show(Invoice $invoice, PaymentAttempt $paymentAttempt, PlacetoPay $placetopay)
    {
        $response = $placetopay->query($paymentAttempt->requestID);
        $paymentAttempt->update([
            'status' => $response->status()->status(),
            'amount' => $response->request->payment()->amount()->total()
        ]);
        if ($paymentAttempt->status == 'APPROVED'){
            $invoice->update([
                'state_id' => '2',
            ]);
            if (empty($invoice->received_at)){
                $invoice->update([
                    'received_at' => Carbon::now()
                ]);
            }
        }
        return view("invoices.payments.show", [
            'invoice' => $invoice,
            'paymentAttempt' => $paymentAttempt,
            'response' => $response
        ]);
    }
}
