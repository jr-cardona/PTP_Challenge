<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Factura</title>
</head>
<body style="font-family: georgia,serif;">
<table class="table">
    <tbody>
    <tr>
        <td>
            <img src="https://dev.placetopay.com/web/wp-content/uploads/2019/02/p2p-logo.svg" width="250" alt="">
        </td>
        <td class="text-center" style="font-size: x-large">
            <span><strong>{{ $invoice->fullname }}</strong></span>
        </td>
    </tr>
    </tbody>
</table>
<div style="border-width: 1px; border-radius: 5px; border-style: solid; margin-top: 8px;">
    <table style="width: 100%; border-collapse: collapse; font-size: medium">
        <tbody>
        <tr>
            <td style="border-style: none solid solid none; border-width: 1px; padding: 3px; background-color: #e3e3e3">Cliente</td>
            <td style="border-style: none solid solid none; border-width: 1px; padding: 3px; width: 35%;">{{ $invoice->client->fullname }}<br /></td>
            <td style="border-style: none solid solid none; border-width: 1px; padding: 3px; background-color: #e3e3e3" nowrap>Fecha de Factura</td>
            <td style="border-style: none none solid; border-width: 1px; padding: 3px;">{{ $invoice->issued_at->toDateString() }}</td>
        </tr>
        <tr>
            <td style="border-style: none solid solid none; border-width: 1px; padding: 3px; background-color: #e3e3e3">Identificación</td>
            <td style="border-style: none solid solid none; border-width: 1px; padding: 3px; ">{{ $invoice->client->document }}<br /></td>
            <td style="border-style: none solid solid none; border-width: 1px; padding: 3px; background-color: #e3e3e3" nowrap>Fecha de Vencimiento</td>
            <td style="border-style: none none solid; border-width: 1px; padding: 3px;">{{ $invoice->expires_at->toDateString() }}</td>
        </tr>
        <tr>
            <td style="border-style: none solid solid none; border-width: 1px; padding: 3px; background-color: #e3e3e3">Celular</td>
            <td style="border-style: none solid solid none; border-width: 1px; padding: 3px; ">{{ $invoice->client->cellphone }}</td>
            <td style="border-style: none solid solid none; border-width: 1px; padding: 3px; background-color: #e3e3e3">Teléfono</td>
            <td style="border-style: none none solid none; border-width: 1px; padding: 3px; ">{{ $invoice->client->phone }}</td>
        </tr>
        <tr>
            <td style="border-style: none solid solid none; border-width: 1px; padding: 3px; background-color: #e3e3e3">Dirección</td>
            <td style="border-style: none solid none none; border-width: 1px; padding: 3px;">{{ $invoice->client->address }}</td>
            <td style="border-style: none solid solid none; border-width: 1px; padding: 3px; background-color: #e3e3e3">Vendedor</td>
            <td style="border-style: none; border-width: 1px; padding: 3px;">{{ $invoice->seller->fullname }}</td>
        </tr>
        </tbody>
    </table>
</div>
<br/>
    <div class="card-header text-center"><h3>{{ __("Lista de productos") }}</h3></div>
    <table class="table table-sm table-striped">
        <thead>
        <tr>
            <th style="background-color: #e3e3e3;" class="text-center" nowrap>{{ __("CÓDIGO") }}</th>
            <th style="background-color: #e3e3e3;" class="text-center" nowrap>{{ __("NOMBRE") }}</th>
            <th style="background-color: #e3e3e3;" class="text-center" nowrap>{{ __("CANTIDAD") }}</th>
            <th style="background-color: #e3e3e3;" class="text-right" nowrap>{{ __("PRECIO UNITARIO") }}</th>
            <th style="background-color: #e3e3e3;" class="text-right" nowrap>{{ __("PRECIO TOTAL") }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoice->products as $product)
            <tr>
                <td class="text-center">{{ $product->id }}</td>
                <td class="text-center" nowrap>{{ $product->name }}</td>
                <td class="text-center">{{ $product->pivot->quantity }}</td>
                <td class="text-right">${{ number_format($product->pivot->unit_price, 2) }}</td>
                <td class="text-right">${{ number_format($product->pivot->unit_price * $product->pivot->quantity, 2) }}</td>
            </tr>
        @endforeach
            <tr>
                <td colspan="3"></td>
                <td class="text-right custom-header">
                    <strong>{{ __("SUBTOTAL") }}</strong>
                </td>
                <td class="text-right">${{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="text-right custom-header">
                    <strong>{{ __("IVA") }}</strong>
                </td>
                <td class="text-right">${{ number_format($invoice->iva_amount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="text-right custom-header">
                    <strong>{{ __("VALOR TOTAL") }}</strong>
                </td>
                <td class="text-right">${{ number_format($invoice->total, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
