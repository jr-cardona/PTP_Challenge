@if(! $invoice->isAnnulled())
    @if(! $invoice->isPaid())
        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-primary" title="Editar">
            <i class="fa fa-edit"></i>@routeIs('invoices.show', $invoice) {{ __("Editar") }} @endif
        </a>
    @endif
    <button type="button" class="btn btn-warning" data-toggle="modal" title="Anular"
            data-route="{{ route("invoices.destroy", $invoice) }}" data-target="#confirmAnnulmentModal">
        <i class="fa fa-exclamation-circle"></i>@routeIs('invoices.show', $invoice) {{ __("Anular") }} @endif
    </button>
@endif
