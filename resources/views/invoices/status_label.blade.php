@if($invoice->isAnnulled())
    <td class="content alert-warning">{{ __("Anulada") }}</td>
@elseif($invoice->isExpired())
    <td class="content alert-danger">{{ __("Vencida") }}</td>
@elseif($invoice->isPaid())
    <td class="content alert-success">{{ __("Pagada") }}</td>
@elseif($invoice->isPending())
    <td class="content alert-secondary">{{ __("Pendiente") }}</td>
@else
    <td class="content alert-info">{{ __("Sin definir") }}</td>
@endif
