<table>
    <thead>
    <tr>
        <th>{{ __("Título") }}</th>
        <th>{{ __("Fecha de creación") }}</th>
        <th>{{ __("Fecha de modifición") }}</th>
        <th>{{ __("Fecha de expedición") }}</th>
        <th>{{ __("Fecha de vencimiento") }}</th>
        <th>{{ __("Fecha de recibo") }}</th>
        <th>{{ __("IVA") }}</th>
        <th>{{ __("Total") }}</th>
        <th>{{ __("Descripción") }}</th>
        <th>{{ __("Estado") }}</th>
        <th>{{ __("Cliente") }}</th>
        <th>{{ __("Vendedor") }}</th>
        <th>{{ __("ID Cliente") }}</th>
        <th>{{ __("ID Vendedor") }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->fullname }}</td>
            <td>{{ $invoice->created_at }}</td>
            <td>{{ $invoice->updated_at }}</td>
            <td>{{ $invoice->issued_at->toDateString() }}</td>
            <td>{{ $invoice->expires_at->toDateString() }}</td>
            <td>{{ $invoice->received_at }}</td>
            <td>{{ Config::get('constants.vat') }}</td>
            <td>{{ $invoice->total }}</td>
            <td>{{ $invoice->description }}</td>
            @include('invoices.status_label')
            <td>{{ $invoice->client->fullname }}</td>
            <td>{{ $invoice->seller->fullname }}</td>
            <td>{{ $invoice->client_id }}</td>
            <td>{{ $invoice->seller_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
