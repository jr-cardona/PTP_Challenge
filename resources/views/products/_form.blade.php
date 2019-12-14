@csrf
<div class="row">
    <div class="col">
        <label for="name" class="required">Nombre</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
               class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="unit_price" class="required">{{ __("Precio unitario") }}</label>
        <input type="text" name="unit_price" id="unit_price" value="{{ old('unit_price', $product->unit_price) }}"
               class="form-control @error('unit_price') is-invalid @enderror">
        @error('unit_price')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col">
        <label for="description">{{ __("Descripción") }}</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">
            {{ old('description', $product->description) }}
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
    <a href="{{ route('products.index') }}" class="btn btn-danger">Volver</a>
</div>
