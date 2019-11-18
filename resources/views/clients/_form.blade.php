@csrf
<div class="row">
    <div class="col">
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" value="{{ old('name', $client->name) }}"
               class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="sic_code">Número de documento</label>
        <input type="number" name="sic_code" id="sic_code" value="{{ old('sic_code', $client->sic_code) }}"
               class="form-control @error('sic_code') is-invalid @enderror">
        @error('sic_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="type_document">Tipo de documento</label>
        <select id="type_document" name="type_document"
                class="form-control @error('type_document') is-invalid @enderror">
            <option value="">--</option>
            <option value="TI" {{ old('type_document', $client->type_document) == "TI" ? 'selected' : '' }}>Tarjeta de identidad</option>
            <option value="CC" {{ old('type_document', $client->type_document) == "CC" ? 'selected' : '' }}>Cédula de ciudadanía</option>
            <option value="NIT" {{ old('type_document', $client->type_document) == "NIT" ? 'selected' : '' }}>NIT</option>
            <option value="PS" {{ old('type_document', $client->type_document) == "PS" ? 'selected' : '' }}>Pasaporte</option>
        </select>
        @error('type_document')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <label for="phone_number">Número telefónico</label>
        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $client->phone_number) }}"
               class="form-control @error('phone_number') is-invalid @enderror">
        @error('phone_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="cell_phone_number">Número de celular</label>
        <input type="text" name="cell_phone_number" id="cell_phone_number" value="{{ old('cell_phone_number', $client->cell_phone_number) }}"
               class="form-control @error('cell_phone_number') is-invalid @enderror">
        @error('cell_phone_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="address">Dirección</label>
        <input type="text" name="address" id="address" value="{{ old('address', $client->address) }}"
               class="form-control @error('address') is-invalid @enderror">
        @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $client->email) }}"
               class="form-control @error('email') is-invalid @enderror">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<br>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Guardar">
    <a href="{{ route('clients.index') }}" class="btn btn-danger">Volver</a>
</div>
