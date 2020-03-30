@if($invoice->isAnnulled())
    <i class="fa fa-ban"></i>
@elseif($invoice->isPaid())
    <i class="fa fa-check-circle"></i>
@elseif($invoice->isExpired())
    <i class="fa fa-exclamation-triangle"></i>
@endif
