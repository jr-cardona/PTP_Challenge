@csrf
<div class="row">
    <div class="col">
        <label for="issued_at" class="required">{{ __("Fecha de Expedición") }}</label>
        <input type="datetime-local" name="issued_at" id="issued_at" value="{{ old('issued_at', $invoice->getDateAttribute($invoice->issued_at)) }}"
               class="form-control @error('issued_at') is-invalid @enderror">
        @error('issued_at')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="overdued_at" class="required">{{ __("Fecha de Vencimiento") }}</label>
        <input type="datetime-local" name="overdued_at" id="overdued_at" value="{{ old('overdued_at', $invoice->getDateAttribute($invoice->overdued_at)) }}"
               class="form-control @error('overdued_at') is-invalid @enderror">
        @error('overdued_at')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="seller_id" class="required">{{ __("Vendedor") }}</label>
        <v-select label="name" :filterable="false" :options="options" @search="searchSeller">
            <template slot="no-options">
                {{ __("Ingresa el nombre del vendedor...") }}
            </template>
            <template slot="option" slot-scope="option">
                <div class="d-center">
                    @{{ option.name }}
                </div>
            </template>
            <template slot="selected-option" slot-scope="option">
                <div class="selected d-center">
                    @{{ option.name }}
                </div>
                <input type="hidden" name="seller_id" id="seller_id" :value='option.id'>
            </template>
        </v-select>
        @error('seller_id')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <label for="vat" class="required">{{ __("IVA") }} (%)</label>
        <input type="number" step="0.01" name="vat" id="vat" value="{{ old('vat', $invoice->vat) }}"
               class="form-control @error('vat') is-invalid @enderror" placeholder="Ingresa el IVA">
        @error('vat')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="state_id" class="required">{{ __("Estado") }}</label>
        <select id="state_id" name="state_id" class="form-control @error('state_id') is-invalid @enderror">
            <option value="">{{ __("Selecciona el estado") }}</option>
            @foreach($states as $state)
                <option value="{{ $state->id }}" {{old('state_id', $invoice->state_id) == $state->id ? 'selected' : ''}}>
                    {{ $state->name }}
                </option>
            @endforeach
        </select>
        @error('state_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="client" class="required">{{ __("Cliente") }}</label>
        <v-select label="name" :filterable="false" :options="options" @search="searchClient">
            <template slot="no-options">
                {{ __("Ingresa el nombre del cliente...") }}
            </template>
            <template slot="option" slot-scope="option">
                <div class="d-center">
                    @{{ option.name }}
                </div>
            </template>
            <template slot="selected-option" slot-scope="option">
                <div class="selected d-center">
                    @{{ option.name }}
                </div>
                <input type="hidden" name="client_id" id="client_id" :value='option.id'>
            </template>
        </v-select>
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
        <label for="description">{{ __("Descripción") }}</label>
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
    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-danger">{{ __("Volver") }}</a>
</div>
