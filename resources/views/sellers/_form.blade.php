@csrf
<div class="row">
    <div class="col form-group">
        <label for="name" class="required">{{ __("Nombre") }}</label>
        <input type="text" name="name" id="name" value="{{ old('name', $seller->name) }}"
               class="form-control @error('name') is-invalid @enderror" placeholder="Ingresa el nombre">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col form-group">
        <label for="surname" class="required">{{ __("Apellido") }}</label>
        <input type="text" name="surname" id="surname" value="{{ old('surname', $seller->surname) }}"
               class="form-control @error('surname') is-invalid @enderror" placeholder="Ingresa el apellido">
        @error('surname')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="type_document_id" class="required">{{ __("Tipo de documento") }}</label>
        <select id="type_document_id" name="type_document_id"
                class="form-control @error('type_document_id') is-invalid @enderror">
            <option value="">{{ __("Ingresa el tipo de documento") }} </option>
            @foreach($type_documents as $type_document)
                <option value="{{ $type_document->id }}" {{ old('type_document_id', $seller->type_document_id) == $type_document->id ? 'selected' : '' }}>
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
        <input type="number" name="document" id="document" value="{{ old('document', $seller->document) }}"
               class="form-control @error('document') is-invalid @enderror" placeholder="Ingresa el número de documento">
        @error('document')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="phone_number">{{ __("Número telefónico") }}</label>
        <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', $seller->phone_number) }}"
               class="form-control @error('phone_number') is-invalid @enderror" placeholder="Ingresa el número telefónico">
        @error('phone_number')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="cell_phone_number" class="required">{{ __("Número de celular") }}</label>
        <input type="tel" name="cell_phone_number" id="cell_phone_number" value="{{ old('cell_phone_number', $seller->cell_phone_number) }}"
               class="form-control @error('cell_phone_number') is-invalid @enderror" placeholder="Ingresa el número de celular">
        @error('cell_phone_number')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="address" class="required">{{ __("Dirección") }}</label>
        <input type="text" name="address" id="address" value="{{ old('address', $seller->address) }}"
               class="form-control @error('address') is-invalid @enderror" placeholder="Ingresa la dirección">
        @error('address')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <label for="email" class="required">{{ __("Email") }}</label>
        <input type="email" name="email" id="email" value="{{ old('email', $seller->email) }}"
               class="form-control @error('email') is-invalid @enderror" placeholder="Ingresa el correo electrónico">
        @error('email')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<br>
