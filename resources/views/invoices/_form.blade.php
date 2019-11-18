@csrf
<div class="row">
    <div class="col">
        <label for="number">Número de factura</label>
        <input type="text" name="number" id="number" value="{{ old('number', $invoice->number) }}"
               class="form-control @error('number') is-invalid @enderror">
        @error('number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="invoice_date">Fecha de Facturación</label>
        <input type="datetime" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', $invoice->invoice_date) }}"
               class="form-control @error('invoice_date') is-invalid @enderror">
        @error('invoice_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="expedition_date">Fecha de Expedición</label>
        <input type="datetime" name="expedition_date" id="expedition_date" value="{{ old('expedition_date', $invoice->expedition_date) }}"
               class="form-control @error('expedition_date') is-invalid @enderror">
        @error('expedition_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="due_date">Fecha de Vencimiento</label>
        <input type="datetime" name="due_date" id="due_date" value="{{ old('due_date', $invoice->due_date) }}"
               class="form-control @error('due_date') is-invalid @enderror">
        @error('due_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <label for="vat">IVA</label>
        <input type="number" step="0.01" name="vat" id="vat" value="{{ old('vat', $invoice->vat) }}"
               class="form-control @error('vat') is-invalid @enderror">
        @error('vat')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="total">Valor total</label>
        <input type="number" name="total" id="total" value="{{ old('total', $invoice->total) }}"
        class="form-control @error('total') is-invalid @enderror">
        @error('total')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="status">Estado</label>
        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
            <option value="">--</option>
            <option value="Paid" {{ old('status', $invoice->status) == "Paid" ? 'selected' : '' }}>Pagada</option>
            <option value="Draft" {{ old('status', $invoice->status) == "Draft" ? 'selected' : '' }}>Borrador</option>
            <option value="Pending" {{ old('status', $invoice->status) == "Pending" ? 'selected' : '' }}>Pendiente</option>
        </select>
        @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="client_id">Cliente</label>
        <select type="text" name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror">
            <option value="">--</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ old('client_id', $invoice->client_id) == $client->id ? 'selected' : '' }}>
                    {{ $client->name }}
                </option>
            @endforeach
        </select>
        @error('client_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<br>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Guardar">
    <a href="{{ route('invoices.index') }}" class="btn btn-danger">Volver</a>
</div>
