<table>
    <thead>
    <tr>
        <th>{{ __("Número") }}</th>
        <th>{{ __("Fecha de expedición") }}</th>
        <th>{{ __("Fecha de vencimiento") }}</th>
        <th>{{ __("Fecha de recibo") }}</th>
        <th>{{ __("IVA") }}</th>
        <th>{{ __("Descripción") }}</th>
        <th>{{ __("Estado") }}</th>
        <th>{{ __("Cliente") }}</th>
        <th>{{ __("Vendedor") }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->number }}</td>
            <td>{{ $invoice->issued_at }}</td>
            <td>{{ $invoice->expired_at }}</td>
            <td>{{ $invoice->received_at }}</td>
            <td>{{ $invoice->vat }}</td>
            <td>{{ $invoice->description }}</td>
            <td>{{ $invoice->state_id }}</td>
            <td>{{ $invoice->client_id }}</td>
            <td>{{ $invoice->seller_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
