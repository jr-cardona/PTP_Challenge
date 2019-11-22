@csrf
<div class="row">
    <div class="col">
        <label for="received_at">Fecha de Recibo</label>
        <input type="datetime-local" name="received_at" id="received_at" value="{{ old('received_at', $invoice->getDateAttribute($invoice->received_at)) }}"
               class="form-control @error('received_at') is-invalid @enderror">
        @error('received_at')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="issued_at" class="required">Fecha de Expedición</label>
        <input type="datetime-local" name="issued_at" id="issued_at" value="{{ old('issued_at', $invoice->getDateAttribute($invoice->received_at)) }}"
               class="form-control @error('issued_at') is-invalid @enderror">
        @error('issued_at')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="overdued_at" class="required">Fecha de Vencimiento</label>
        <input type="datetime-local" name="overdued_at" id="overdued_at" value="{{ old('overdued_at', $invoice->getDateAttribute($invoice->received_at)) }}"
               class="form-control @error('overdued_at') is-invalid @enderror">
        @error('overdued_at')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <label for="vat" class="required">IVA (%)</label>
        <input type="number" step="0.01" name="vat" id="vat" value="{{ old('vat', $invoice->vat) }}"
               class="form-control @error('vat') is-invalid @enderror">
        @error('vat')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
<<<<<<< Updated upstream
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
=======
        <label for="status" class="required">Estado</label>
>>>>>>> Stashed changes
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
        <label for="client_id" class="required">Cliente</label>
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
<div class="row">
    <div class="col">
        <label for="description">Descripción</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">
            {{ old('description', $invoice->description) }}
        </textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<br>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Guardar">
    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-danger">Volver</a>
</div>
