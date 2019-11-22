@csrf
<div class="row">
    <div class="col form-group">
        <label for="name" class="required">Nombre</label>
        <input type="text" name="name" id="name" value="{{ old('name', $client->name) }}"
               class="form-control @error('name') is-invalid @enderror" placeholder="Ingresa tu nombre">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="sic_code" class="required">Número de documento</label>
        <input type="number" name="sic_code" id="sic_code" value="{{ old('sic_code', $client->sic_code) }}"
               class="form-control @error('sic_code') is-invalid @enderror" placeholder="Ingresa tu número de documento">
        @error('sic_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="type_document" class="required">Tipo de documento</label>
        <select id="type_document" name="type_document"
                class="form-control @error('type_document') is-invalid @enderror">
            <option value="">--</option>
            <option value="TI" {{ old('type_document', $client->type_document) == "TI" ? 'selected' : '' }}>Tarjeta de identidad</option>
            <option value="CC" {{ old('type_document', $client->type_document) == "CC" ? 'selected' : '' }}>Cédula de ciudadanía</option>
            <option value="NIT" {{ old('type_document', $client->type_document) == "NIT" ? 'selected' : '' }}>NIT</option>
            <option value="TP" {{ old('type_document', $client->type_document) == "TP" ? 'selected' : '' }}>Pasaporte</option>
            <option value="CE" {{ old('type_document', $client->type_document) == "CE" ? 'selected' : '' }}>Cédula de extranjería</option>
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
        <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', $client->phone_number) }}"
               class="form-control @error('phone_number') is-invalid @enderror" placeholder="Ingresa tu número telefónico">
        @error('phone_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="cell_phone_number" class="required">Número de celular</label>
        <input type="tel" name="cell_phone_number" id="cell_phone_number" value="{{ old('cell_phone_number', $client->cell_phone_number) }}"
               class="form-control @error('cell_phone_number') is-invalid @enderror" placeholder="Ingresa tu número de celular">
        @error('cell_phone_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="address" class="required">Dirección</label>
        <input type="text" name="address" id="address" value="{{ old('address', $client->address) }}"
               class="form-control @error('address') is-invalid @enderror" placeholder="Ingresa tu dirección">
        @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="email" class="required">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $client->email) }}"
               class="form-control @error('email') is-invalid @enderror" placeholder="Ingresa tu correo electrónico">
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
