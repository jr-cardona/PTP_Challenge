<table>
    <thead>
    <tr>
        <th>Número</th>
        <th>Fecha de expedición</th>
        <th>Fecha de vencimiento</th>
        <th>Fecha de recibo</th>
        <th>IVA</th>
        <th>Descripción</th>
        <th>Estado</th>
        <th>Cliente</th>
        <th>Vendedor</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->number }}</td>
            <td>{{ $invoice->issued_at }}</td>
            <td>{{ $invoice->overdued_at }}</td>
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
