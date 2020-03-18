@csrf
<div class="row">
    <div class="col form-group">
        <label for="name" class="required">{{ __("Nombre") }}</label>
        <input type="text" name="name" id="name" value="{{ old('name', isset($client->user->name) ? $client->user->name : '') }}" required minlength="3" maxlength="50"
               class="form-control @error('name') is-invalid @enderror" placeholder="Ingresa el nombre">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @else
            <small class="form-text text-muted">
                {{ __("Entre 3 y 50 caracteres") }}
            </small>
        @enderror
    </div>
    <div class="col form-group">
        <label for="surname" class="required">{{ __("Apellidos") }}</label>
        <input type="text" name="surname" id="surname" value="{{ old('surname', isset($client->user->surname) ? $client->user->surname : '') }}" required minlength="3" maxlength="50"
               class="form-control @error('surname') is-invalid @enderror" placeholder="Ingresa el apellido">
        @error('surname')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @else
            <small class="form-text text-muted">
                {{ __("Entre 3 y 50 caracteres") }}
            </small>
        @enderror
    </div>
    <div class="col">
        <label for="type_document_id" class="required">{{ __("Tipo de documento") }}</label>
        <select id="type_document_id" name="type_document_id" required
                class="form-control @error('type_document_id') is-invalid @enderror">
            <option value="">{{ __("Ingresa el tipo de documento") }} </option>
            @foreach($type_documents as $type_document)
                <option value="{{ $type_document->id }}" {{ old('type_document_id', $client->type_document_id) == $type_document->id ? 'selected' : '' }}>
                    {{ $type_document->fullname }}
                </option>
            @endforeach
        </select>
        @error('type_document_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <label for="document" class="required">{{ __("Número de documento") }}</label>
        <input type="tel" name="document" id="document" value="{{ old('document', $client->document) }}"
               class="form-control @error('document') is-invalid @enderror" placeholder="Ingresa el número de documento" required minlength="8" maxlength="10">
        @error('document')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @else
            <small class="form-text text-muted">
                {{ __("Debe ser numérico entre 8 y 10 caracteres") }}
            </small>
        @enderror
    </div>
    <div class="col">
        <label for="phone">{{ __("Número telefónico") }}</label>
        <input type="tel" name="phone" id="phone" value="{{ old('phone', $client->phone) }}"
               class="form-control @error('phone') is-invalid @enderror" placeholder="Ingresa el número telefónico">
        @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @else
            <small class="form-text text-muted">
                {{ __("Debe ser numérico de 7 caracteres") }}
            </small>
        @enderror
    </div>
    <div class="col">
        <label for="cellphone" class="required">{{ __("Número de celular") }}</label>
        <input type="tel" name="cellphone" id="cellphone" value="{{ old('cellphone', $client->cellphone) }}"
               class="form-control @error('cellphone') is-invalid @enderror" placeholder="Ingresa el número de celular" required minlength="10" maxlength="10">
        @error('cellphone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @else
            <small class="form-text text-muted">
                {{ __("Debe ser numérico de 10 caracteres") }}
            </small>
        @enderror
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <label for="address" class="required">{{ __("Dirección") }}</label>
        <input type="text" name="address" id="address" value="{{ old('address', $client->address) }}" required minlength="5" maxlength="100"
               class="form-control @error('address') is-invalid @enderror" placeholder="Ingresa la dirección">
        @error('address')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @else
            <small class="form-text text-muted">
                {{ __("Entre 5 y 100 caracteres") }}
            </small>
            @enderror
    </div>
    <div class="col">
        <label for="email" class="required">{{ __("Email") }}</label>
        <input type="email" name="email" id="email" value="{{ old('email', isset($client->user->email) ? $client->user->email : '') }}" required minlength="5" maxlength="100"
               class="form-control @error('email') is-invalid @enderror" placeholder="Ingresa el correo electrónico">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @else
            <small class="form-text text-muted">
                {{ __("Debe ser email válido entre 5 y 100 caracteres") }}
            </small>
        @enderror
    </div>
</div>
<br>
