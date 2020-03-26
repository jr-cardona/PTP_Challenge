<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Invoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Invoice $invoice
     * @return bool
     */
    public function viewAny(User $user, Invoice $invoice = null)
    {
        return $user->can('View all invoices') || $user->can('View invoices');
    }

    /**
     * Determine whether the user can view invoices.
     *
     * @param User $user
     * @param Invoice $invoice
     * @return mixed
     */
    public function view(User $user, Invoice $invoice)
    {
        if ($user->can('View all invoices')) {
            return true;
        } elseif ($user->can('View invoices')) {
            return $user->id === $invoice->created_by || $user->id === $invoice->client_id;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can create invoices.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user, Invoice $invoice = null)
    {
        return $user->can('Create invoices');
    }

    /**
     * Determine whether the user can edit invoices.
     *
     * @param User $user
     * @param Invoice $invoice
     * @return mixed
     */
    public function update(User $user, Invoice $invoice)
    {
        if ($invoice->isPaid() || $invoice->isAnnulled()) {
            return false;
        }
        if ($user->can('Edit all invoices')) {
            return true;
        }
        if ($user->can('Edit invoices')) {
            return $user->id === $invoice->created_by;
        }
        return false;
    }

    /**
     * Determine whether the user can annul invoices.
     *
     * @param User $user
     * @param Invoice $invoice
     * @return mixed
     */
    public function delete(User $user, Invoice $invoice)
    {
        if ($invoice->isAnnulled()){
            return false;
        }
        if ($user->can('Annul all invoices')){
            return true;
        }
        if ($user->can('Annul invoices')) {
            return $user->id === $invoice->created_by;
        }
        return false;
    }

    /**
     * Determine whether the user can export invoices.
     *
     * @param User $user
     * @param Invoice $invoice
     * @return mixed
     */
    public function export(User $user, Invoice $invoice = null)
    {
        return $user->can('Export all invoices');
    }

    /**
     * Determine whether the user can import invoices.
     *
     * @param User $user
     * @param Invoice $invoice
     * @return mixed
     */
    public function import(User $user, Invoice $invoice = null)
    {
        return $user->can('Import all invoices') || $user->can('Import invoices');
    }

    /**
     * Determine whether the user can pay his invoices.
     *
     * @param User $user
     * @param Invoice $invoice
     * @return mixed
     */
    public function pay(User $user, Invoice $invoice)
    {
        if ($invoice->isPaid() || $invoice->isAnnulled() || $invoice->total == 0) {
            return false;
        }
        if ($user->can('Pay invoices') &&
            $user->id === $invoice->client_id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can receive his invoices.
     *
     * @param User $user
     * @param Invoice $invoice
     * @return mixed
     */
    public function receive(User $user, Invoice $invoice)
    {
        if ($invoice->isAnnulled() || isset($invoice->received_at)){
            return false;
        }
        if ($user->can('Receive invoices') &&
            $user->id === $invoice->client_id){
            return true;
        }
        return false;
    }

    public function print(User $user, Invoice $invoice)
    {
        if ($user->can('Print all invoices')) {
            return true;
        } elseif ($user->can('Print invoices')) {
            return $user->id === $invoice->created_by;
        } else {
            return false;
        }
    }
}
