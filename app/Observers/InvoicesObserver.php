<?php

namespace App\Observers;

use App\Entities\Invoice;

class InvoicesObserver
{
    public function creating(Invoice $invoice)
    {
        if (! $invoice->created_by) $invoice->created_by = auth()->user()->id;
        $invoice->updated_by = $invoice->created_by;
        $invoice->expires_at = $invoice->issued_at->addMonth();
    }

    public function updating(Invoice $invoice)
    {
        $invoice->updated_by = auth()->user()->id;
        $invoice->expires_at = $invoice->issued_at->addMonth();
    }
}
