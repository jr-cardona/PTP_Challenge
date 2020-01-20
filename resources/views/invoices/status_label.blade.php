@if(is_null($invoice))
    <td class="content alert-info">En espera</td>
@elseif($invoice->isExpired())
    <td class="content alert-danger">{{ $invoice->state->name }}</td>
@elseif($invoice->isPaid())
    <td class="content alert-success">{{ $invoice->state->name }}</td>
@elseif($invoice->isPending())
    <td class="content alert-warning">{{ $invoice->state->name }}</td>
@endif
