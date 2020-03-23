<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Filtrar por</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="searchForm" action="{{ route('users.index') }}" method="get">
                    <input type="hidden" id="format" name="format">
                    <div class="form-group row">
                        <div class="col">
                            <label>{{ __("Nombre") }}</label>
                            <input type="hidden" id="old_user_fullname" name="old_user_fullname" value="{{ $request->get('user') }}">
                            <input type="hidden" id="old_created_by" name="old_created_by" value="{{ $request->get('id') }}">
                            <v-select v-model="old_user_values" label="fullname" :filterable="false" :options="options" @search="searchUser"
                                      class="form-control">
                                <template slot="no-options">
                                    {{ __("Ingresa el nombre...") }}
                                </template>
                            </v-select>
                            <input type="hidden" name="user" id="user" :value="(old_user_values) ? old_user_values.fullname : '' ">
                            <input type="hidden" name="id" id="id" :value="(old_user_values) ? old_user_values.id : '' ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="email">{{ __("Correo electrónico") }}</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Correo electrónico" value="{{ $request->get('email') }}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> {{ __("Cerrar") }}
                </button>
                <button type="submit" form="searchForm" class="btn btn-primary">
                    <i class="fa fa-search"></i> {{ __("Buscar") }}
                </button>
            </div>
        </div>
    </div>
</div>
