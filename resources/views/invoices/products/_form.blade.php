<div class="col">
    <label class="required" for="quantity">{{ __("Cantidad") }}</label>
    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $quantity) }}"
           class="form-control @error('quantity') is-invalid @enderror" required min="1" max="9999">
    @error('quantity')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @else
        <small class="form-text text-muted">
            {{ __("Debe ser numérico entre 1 y 9999") }}
        </small>
    @enderror
</div>
