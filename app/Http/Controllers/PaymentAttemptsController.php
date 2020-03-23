<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Entities\Invoice;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Entities\PaymentAttempt;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Dnetix\Redirection\Exceptions\PlacetoPayException;

class PaymentAttemptsController extends Controller
{
    /**
     * @param Invoice $invoice
     * @return View
     * @throws AuthorizationException
     */
    public function create(Invoice $invoice)
    {
        $this->authorize('pay', $invoice);

        if ($invoice->isPaid()) {
            return redirect()->route('invoices.show', $invoice)->withError(__("La factura ya se encuentra pagada"));
        }
        if ($invoice->isAnnulled()) {
            return redirect()->route('invoices.show', $invoice)->withError(__("La factura se encuentra anulada"));
        }
        if ($invoice->total == 0) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura no tiene productos a pagar, intente nuevamente"));
        }
        return view('invoices.payments.create', compact('invoice'));
    }

    /**
     * @param PaymentAttempt $paymentAttempt
     * @param Invoice $invoice
     * @param Request $request
     * @param PlacetoPay $placetopay
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws PlacetoPayException
     */
    public function store(Invoice $invoice, PaymentAttempt $paymentAttempt,
                          Request $request, PlacetoPay $placetopay)
    {
        $this->authorize('pay', $invoice);

        $paymentAttempt->save();
        $request_c = [
            "buyer" => [
                "name" => $invoice->client->user->name,
                "surname" => $invoice->client->user->surname,
                "email" => $invoice->client->user->email,
                "documentType" => $invoice->client->type_document->name,
                "document" => $invoice->client->document,
                "mobile" => $invoice->client->cellphone,
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
        }
    }

    /**
     * @param Invoice $invoice
     * @param PaymentAttempt $paymentAttempt
     * @param PlacetoPay $placetopay
     * @return View
     * @throws AuthorizationException
     */
    public function show(Invoice $invoice, PaymentAttempt $paymentAttempt, PlacetoPay $placetopay)
    {
        $this->authorize('pay', $invoice);

        $response = $placetopay->query($paymentAttempt->requestID);
        $paymentAttempt->update([
            'status' => $response->status()->status(),
            'amount' => $response->request()->payment()->amount()->total()
        ]);
        if ($paymentAttempt->status == 'APPROVED') {
            $invoice->update([
                'paid_at' => Carbon::now(),
            ]);
            if (empty($invoice->received_at)) {
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
