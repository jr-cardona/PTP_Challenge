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
    @foreach($clients as $client)
        <tr>
            <td>{{ $client->type_document->fullname }}</td>
            <td>{{ $client->document }}</td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->surname }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->cell_phone_number }}</td>
            <td>{{ $client->phone_number }}</td>
            <td>{{ $client->address }}</td>
            <td>{{ $client->type_document_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
