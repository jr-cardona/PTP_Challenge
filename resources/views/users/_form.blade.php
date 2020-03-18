<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-center">{{ __("Datos personales") }}</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="required">{{ __("Nombre") }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required minlength="3" maxlength="50"
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
                <div class="form-group">
                    <label for="surname" class="required">{{ __("Apellidos") }}</label>
                    <input type="text" name="surname" id="surname" value="{{ old('surname', $user->surname) }}" required minlength="3" maxlength="50"
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
                <div class="form-group">
                    <label for="email" class="required">{{ __("Email") }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required minlength="5" maxlength="100"
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
        </div>
        <br/>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-center">{{ __("Contraseña") }}</h3>
            </div>
            <div class="card-body">
                @if($edit)
                    <div class="form-group">
                        <label for="current_password">{{ __("Contraseña actual") }}</label>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="current_password" name="current_password" type="password" placeholder="Ingresa la contraseña actual"
                                   class="form-control @error('current_password') is-invalid @enderror" @if(!$edit) required @endif>
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label for="password" @if(!$edit) class="required" @endif>
                        {{ __("Nueva contraseña") }}
                    </label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="password" name="password" type="password" placeholder="Ingresa la contraseña" autocomplete="new-password"
                               class="form-control @error('password') is-invalid @enderror" @if(!$edit) required @endif>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <label for="password-confirm" @if(!$edit) class="required" @endif>
                    {{ __("Confirmar contraseña") }}
                </label>
                <div class="form-group">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="password-confirm" name="password_confirmation" type="password" placeholder="Confirma la contraseña" autocomplete="new-password"
                               class="form-control" @if(!$edit) required @endif>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @role('Admin')
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center">{{ __("Roles") }}</h3>
                </div>
                <div class="card-body">
                    @foreach($roles as $id => $name)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="{{ $name }}" onclick="checkRoles()"
                                       id="role_{{ $id }}" name="roles[]"
                                    {{ $user->roles->contains($id) ? 'checked' : '' }}>
                                {{ $name }}
                            </label>
                        </div>
                    @endforeach
                    <input type="hidden" id="total_roles" name="total_roles" value="{{ $roles->count() }}">
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header text-center">
                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#permissions">
                        <h3>{{ __("Permisos") }}</h3>
                    </button>
                </div>
                <div id="permissions" class="collapse">
                    <div class="card-body">
                        @foreach($permissions as $id => $name)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{ $id }}" disabled="disabled"
                                           id="permission_{{ $id }}" name="permission_{{ $id }}"
                                        {{ $user->permissions->contains($id) ? 'checked' : '' }}>
                                    {{ $name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endrole
</div>
@push('scripts')
    <script>
        $(document).ready(function(){
            checkRoles();
        });

        function checkRoles(){
            $('input[type=checkbox][name^="permission"]').prop('checked', false);
            let total_roles = document.getElementById('total_roles').value;
            for (let i = 1; i <= total_roles ; i++) {
                if( $('#role_' + i).prop('checked') ){
                    if (i === 1){
                        $('input[type=checkbox][name^="permission"]').prop('checked', true);
                    } else {
                        checkPermissions(i);
                    }
                }
            }
        }

        function checkPermissions(role_id) {
            $.ajax({
                type: 'GET',
                url: '/permisos/buscar',
                data: { role_id: role_id },
                success: function(result){
                    result.permissions.forEach(function(permission){
                        $('#permission_' + permission.id).prop("checked", true);
                    });
                }
            });
        }
    </script>
@endpush
