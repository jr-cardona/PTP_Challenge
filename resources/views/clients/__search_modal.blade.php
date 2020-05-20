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
                <form id="searchForm" action="{{ route('clients.index') }}" method="get">
                    <input type="hidden" id="format" name="format">
                    <div class="form-group row">
                        <div class="col">
                            <label>{{ __("Nombre") }}</label>
                            <input type="hidden" id="old_client_fullname" name="old_client_fullname" value="{{ $request->get('client') }}">
                            <input type="hidden" id="old_client_id" name="old_client_id" value="{{ $request->get('id') }}">
                            <v-select v-model="old_client_values" label="fullname" :filterable="false" :options="options" @search="searchClient"
                                      class="form-control">
                                <template slot="no-options">
                                    {{ __("Ingresa el nombre...") }}
                                </template>
                            </v-select>
                            <input type="hidden" name="client" id="client" :value="(old_client_values) ? old_client_values.fullname : '' ">
                            <input type="hidden" name="id" id="id" :value="(old_client_values) ? old_client_values.id : '' ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="email">{{ __("Correo electrónico") }}</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Correo electrónico" value="{{ $request->get('email') }}">
                        </div>
                        <div class="col">
                            <label for="email">{{ __("Celular") }}</label>
                            <input type="text" id="cellphone" name="cellphone" class="form-control" placeholder="Celular" value="{{ $request->get('cellphone') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="type_document_id">{{ __("Tipo de documento") }}</label>
                            <select id="type_document_id" name="type_document_id" class="form-control">
                                <option value="">--</option>
                                @foreach($typeDocuments as $typeDocument)
                                    <option value="{{ $typeDocument->id }}" {{ $request->get('type_document_id') == $typeDocument->id ? 'selected' : ''}}>
                                        {{ $typeDocument->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="document">{{ __("Número de documento") }}</label>
                            <input type="number" id="document" name="document" class="form-control" placeholder="No. Documento" value="{{ $request->get('document') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="per_page">{{ __("Registros por página") }}</label>
                            <select id="per_page" name="per_page" class="form-control">
                                @for($i = 10; $i <= 100; $i += 10)
                                    <option value="{{ $i }}" {{ $clients->perPage() == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
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
