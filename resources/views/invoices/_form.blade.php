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
        <input type="hidden" id="old_seller_name" name="old_seller_name" value="{{ old('seller', isset($invoice->seller->name) ? $invoice->seller->name : '') }}">
        <input type="hidden" id="old_seller_id" name="old_seller_id" value="{{ old('seller_id', isset($invoice->seller->id) ? $invoice->seller->id : '') }}">
        <v-select v-model="old_seller_values" label="name" :filterable="false" :options="options" @search="searchSeller"
                  class="form-control @error('seller_id') is-invalid @enderror" >
            <template slot="no-options">
                {{ __("Ingresa el nombre del vendedor...") }}
            </template>
        </v-select>
        <input type="hidden" name="seller" id="seller" :value="(old_seller_values) ? old_seller_values.name : '' ">
        <input type="hidden" name="seller_id" id="seller_id" :value="(old_seller_values) ? old_seller_values.id : '' ">
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
        <label for="client_id" class="required">{{ __("Cliente") }}</label>
        <input type="hidden" id="old_client_name" name="old_client_name" value="{{ old('client', isset($invoice->seller->name) ? $invoice->seller->name : '') }}">
        <input type="hidden" id="old_client_id" name="old_client_id" value="{{ old('client_id', isset($invoice->seller->name) ? $invoice->seller->name : '') }}">
        <v-select v-model="old_client_values" label="name" :filterable="false" :options="options" @search="searchClient"
                  class="form-control @error('client_id') is-invalid @enderror">
            <template slot="no-options">
                {{ __("Ingresa el nombre del cliente...") }}
            </template>
        </v-select>
        <input type="hidden" name="client" id="client" :value="(old_client_values) ? old_client_values.name : '' ">
        <input type="hidden" name="client_id" id="client_id" :value="(old_client_values) ? old_client_values.id : '' ">
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
