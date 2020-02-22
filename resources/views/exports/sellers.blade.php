<table>
    <thead>
    <tr>
        <th>{{ __("Tipo de documento") }}</th>
        <th>{{ __("Número documento") }}</th>
        <th>{{ __("Nombre") }}</th>
        <th>{{ __("Apellido") }}</th>
        <th>{{ __("Correo electrónico") }}</th>
        <th>{{ __("Teléfono celular") }}</th>
        <th>{{ __("Teléfono fijo") }}</th>
        <th>{{ __("Dirección") }}</th>
        <th>{{ __("ID Documento") }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sellers as $seller)
        <tr>
            <td>{{ $seller->type_document->fullname }}</td>
            <td>{{ $seller->document }}</td>
            <td>{{ $seller->name }}</td>
            <td>{{ $seller->surname }}</td>
            <td>{{ $seller->email }}</td>
            <td>{{ $seller->cell_phone_number }}</td>
            <td>{{ $seller->phone_number }}</td>
            <td>{{ $seller->address }}</td>
            <td>{{ $seller->type_document_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
