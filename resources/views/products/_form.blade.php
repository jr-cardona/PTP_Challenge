@csrf
<div class="row">
    <div class="col">
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
               class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col">
        <label for="description">Descripción</label>
        <textarea name="description" id="description" value="{{ old('description', $product->description) }}"
                  class="form-control @error('description') is-invalid @enderror"></textarea>
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
