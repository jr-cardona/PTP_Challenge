<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Invoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function viewAll(User $user, Invoice $invoice = null)
    {
        return $user->can('invoices.list.all');
    }

    public function viewAssociated(User $user, Invoice $invoice = null)
    {
        return $user->can('invoices.list.associated');
    }

    public function viewAny(User $user, Invoice $invoice = null)
    {
        return $user->can('invoices.list.all') || $user->can('invoices.list.associated');
    }

    public function view(User $user, Invoice $invoice)
    {
        if ($user->can('invoices.list.all')) {
            return true;
        }
        if ($user->can('invoices.list.associated')) {
            return $user->id === $invoice->created_by || $user->id === $invoice->client_id;
        }
        return false;
    }

    public function create(User $user, Invoice $invoice = null)
    {
        return $user->can('invoices.create');
    }

    public function update(User $user, Invoice $invoice)
    {
        if ($invoice->isPaid() || $invoice->isAnnulled()) {
            return false;
        }
        if ($user->can('invoices.edit.all')) {
            return true;
        }
        if ($user->can('invoices.edit.associated')) {
            return $user->id === $invoice->created_by;
        }
        return false;
    }

    public function delete(User $user, Invoice $invoice)
    {
        if ($invoice->isAnnulled()) {
            return false;
        }
        if ($user->can('invoices.annul.all')) {
            return true;
        }
        if ($user->can('invoices.annul.associated')) {
            return $user->id === $invoice->created_by;
        }
        return false;
    }

    public function export(User $user, Invoice $invoice = null)
    {
        return $user->can('invoices.export.all');
    }

    public function import(User $user, Invoice $invoice = null)
    {
        return $user->can('invoices.import.all') || $user->can('invoices.import.associated');
    }

    public function pay(User $user, Invoice $invoice)
    {
        if ($invoice->isPaid() || $invoice->isAnnulled() || $invoice->total == 0) {
            return false;
        }
        if ($user->can('invoices.pay.all')) {
            return true;
        }
        if ($user->can('invoices.pay.associated')) {
            return $user->id === $invoice->client_id;
        }
        return false;
    }

    public function receive(User $user, Invoice $invoice)
    {
        if ($invoice->isAnnulled() || isset($invoice->received_at)) {
            return false;
        }
        if ($user->can('invoices.receive.all')) {
            return true;
        }
        if ($user->can('invoices.receive.associated')) {
            return $user->id === $invoice->client_id;
        }
        return false;
    }

    public function print(User $user, Invoice $invoice)
    {
        if ($invoice->isAnnulled()) {
            return false;
        }
        if ($user->can('invoices.print.all')) {
            return true;
        }
        if ($user->can('invoices.print.associated')) {
            return $user->id === $invoice->created_by;
        }
        return false;
    }
}
