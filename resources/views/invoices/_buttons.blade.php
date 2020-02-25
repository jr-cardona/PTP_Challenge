@if(! $invoice->isAnnulled())
    @if(! $invoice->isPaid())
        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-primary" title="Editar">
            <i class="fa fa-edit"></i>@routeIs('invoices.show', $invoice) {{ __("Editar") }} @endif
        </a>
    @endif
    <button type="submit" form="annul" class="btn btn-warning" title="Anular">
        <i class="fa fa-exclamation-circle"></i>@routeIs('invoices.show', $invoice) {{ __("Anular") }} @endif
    </button>
    <form id="annul" action="{{ route('invoices.destroy', $invoice) }}" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endif
