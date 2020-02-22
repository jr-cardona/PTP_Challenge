<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;

class AssignInvoiceFields
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceCreated  $event
     * @return void
     */
    public function handle(InvoiceCreated $event)
    {
        $event->invoice->expires_at = $event->invoice->issued_at->addMonth();
        $event->invoice->save();
    }
}
