<table>
    <thead>
    <tr>
        <th>{{ __("Nombre") }}</th>
        <th>{{ __("Precio unitario") }}</th>
        <th>{{ __("Descripción") }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->unit_price }}</td>
            <td>{{ $product->description }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
