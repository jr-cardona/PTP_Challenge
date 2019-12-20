<div class="col">
    <label class="required" for="quantity">{{ __("Cantidad") }}</label>
    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $quantity) }}"
           class="form-control @error('quantity') is-invalid @enderror">
    @error('quantity')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="col">
    <label class="required" for="unit_price">{{ __("Precio") }}</label>
    <input type="number" step="0.01" name="unit_price" id="unit_price" value="{{ old('unit_price', $unit_price) }}"
           class="form-control @error('unit_price') is-invalid @enderror">
    @error('unit_price')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
