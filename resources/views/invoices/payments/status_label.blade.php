@if($paymentAttempt->isFailed())
    <td class="content alert-danger">{{ $paymentAttempt->readable_status }}</td>
@elseif($paymentAttempt->isApproved())
    <td class="content alert-success">{{ $paymentAttempt->readable_status }}</td>
@elseif($paymentAttempt->isRejected())
    <td class="content alert-danger">{{ $paymentAttempt->readable_status }}</td>
@elseif($paymentAttempt->isPending())
    <td class="content alert-warning">{{ $paymentAttempt->readable_status }}</td>
@else
    <td class="content alert-info">{{ __("En espera") }}</td>
@endif
