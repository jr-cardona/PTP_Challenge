@csrf
<div class="row">
    <div class="col">
        <label for="issued_at" class="required">{{ __("Fecha de Expedición") }}</label>
        <input type="date" name="issued_at" id="issued_at" value="{{ old('issued_at', $invoice->issued) }}"
               class="form-control @error('issued_at') is-invalid @enderror" required>
        @error('issued_at')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @else
            <small class="form-text text-muted">
                {{ __("No debe sobrepasar 1 semana del día actual") }}
            </small>
        @enderror
    </div>
    <div class="col">
        <label for="client_id" class="required">{{ __("Cliente") }}</label>
        <input type="hidden" id="old_client_fullname" name="old_client_fullname" value="{{ old('client', isset($invoice->client->fullname) ? $invoice->client->fullname : $request->get('client')) }}">
        <input type="hidden" id="old_client_id" name="old_client_id" value="{{ old('client_id', isset($invoice->client->id) ? $invoice->client->id : $request->get('client_id')) }}">
        <v-select v-model="old_client_values" label="fullname" :filterable="false" :options="options" @search="searchClient"
                  class="form-control @error('client_id') is-invalid @enderror">
            <template slot="no-options">
                {{ __("Ingresa el nombre del cliente...") }}
            </template>
        </v-select>
        <input type="hidden" name="client" id="client" :value="(old_client_values) ? old_client_values.fullname : '' ">
        <input type="hidden" name="client_id" id="client_id" :value="(old_client_values) ? old_client_values.id : '' ">
        @error('client_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="seller_id" class="required">{{ __("Vendedor") }}</label>
        <input type="hidden" id="old_seller_fullname" name="old_seller_fullname" value="{{ old('seller', isset($invoice->seller->fullname) ? $invoice->seller->fullname : '') }}">
        <input type="hidden" id="old_seller_id" name="old_seller_id" value="{{ old('seller_id', isset($invoice->seller->id) ? $invoice->seller->id : '') }}">
        <v-select v-model="old_seller_values" label="fullname" :filterable="false" :options="options" @search="searchSeller"
                  class="form-control @error('seller_id') is-invalid @enderror" >
            <template slot="no-options">
                {{ __("Ingresa el nombre del vendedor...") }}
            </template>
        </v-select>
        <input type="hidden" name="seller" id="seller" :value="(old_seller_values) ? old_seller_values.fullname : '' ">
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
        <label for="description">{{ __("Descripción") }}</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">
            {{ old('description', $invoice->description) }}
        </textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @else
            <small class="form-text text-muted">
                {{ __("Máximo de caracteres: 255") }}
            </small>
        @enderror
    </div>
</div>
@push('scripts')
    <script src="{{ asset(mix('js/app.js')) }}"></script>
@endpush
