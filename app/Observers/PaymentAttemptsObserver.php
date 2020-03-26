<?php

namespace App\Observers;

use App\Entities\PaymentAttempt;

class PaymentAttemptsObserver
{
    public function creating(PaymentAttempt $paymentAttempt)
    {
        if (! $paymentAttempt->created_by) {
            $paymentAttempt->created_by = auth()->user()->id;
        }
        $paymentAttempt->updated_by = $paymentAttempt->created_by;
    }

    public function updating(PaymentAttempt $paymentAttempt)
    {
        $paymentAttempt->updated_by = auth()->user()->id;
    }
}
