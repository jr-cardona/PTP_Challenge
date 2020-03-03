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
                <form id="searchForm" action="{{ route('sellers.index') }}" method="get">
                    <input type="hidden" id="format" name="format">
                    <div class="form-group row">
                        <div class="col">
                            <label>{{ __("Nombre") }}</label>
                            <input type="hidden" id="old_seller_fullname" name="old_seller_fullname" value="{{ $request->get('seller') }}">
                            <input type="hidden" id="old_seller_id" name="old_seller_id" value="{{ $request->get('id') }}">
                            <v-select v-model="old_seller_values" label="fullname" :filterable="false" :options="options" @search="searchSeller"
                                      class="form-control">
                                <template slot="no-options">
                                    {{ __("Ingresa el nombre...") }}
                                </template>
                            </v-select>
                            <input type="hidden" name="seller" id="seller" :value="(old_seller_values) ? old_seller_values.fullname : '' ">
                            <input type="hidden" name="id" id="id" :value="(old_seller_values) ? old_seller_values.id : '' ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="email">{{ __("Correo electrónico") }}</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Correo electrónico" value="{{ $request->get('email') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="type_document_id">{{ __("Tipo de documento") }}</label>
                            <select id="type_document_id" name="type_document_id" class="form-control">
                                <option value="">--</option>
                                @foreach($type_documents as $type_document)
                                    <option value="{{ $type_document->id }}" {{ $request->get('type_document_id') == $type_document->id ? 'selected' : ''}}>
                                        {{ $type_document->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="document">{{ __("Número de documento") }}</label>
                            <input type="number" id="document" name="document" class="form-control" placeholder="No. Documento" value="{{ $request->get('document') }}">
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
