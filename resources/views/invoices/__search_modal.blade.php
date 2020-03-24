<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header custom-header">
                <h5 class="modal-title" id="searchModalLabel">Filtrar por</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="custom-header">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="searchForm" action="{{ route('invoices.index') }}" method="get">
                    <input type="hidden" id="format" name="format">
                    <div class="form-group row">
                        <div class="col">
                            <label for="issued_init">{{ __("Fecha inicial de expedición") }}</label>
                            <input type="date" name="issued_init" id="issued_init" class="form-control" value="{{ $request->get('issued_init') }}">
                        </div>
                        <div class="col">
                            <label for="issued_final">{{ __("Fecha final de expedición") }}</label>
                            <input type="date" name="issued_final" id="issued_final" class="form-control" value="{{ $request->get('issued_final') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="expires_init">{{ __("Fecha inicial de vencimiento") }}</label>
                            <input type="date" name="expires_init" id="expires_init" class="form-control" value="{{ $request->get('expires_init') }}">
                        </div>
                        <div class="col">
                            <label for="expires_final">{{ __("Fecha final de vencimiento") }}</label>
                            <input type="date" name="expires_final" id="expires_final" class="form-control" value="{{ $request->get('expires_final') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="number">{{ __("Número de factura") }}</label>
                            <input type="number" id="number" name="number" class="form-control" placeholder="No. de factura" value="{{ $request->get('number') }}">
                        </div>
                        <div class="col">
                            <label>{{ __("Producto") }}</label>
                            <input type="hidden" id="old_product_name" name="old_product_name" value="{{ $request->get('product') }}">
                            <input type="hidden" id="old_product_id" name="old_product_id" value="{{ $request->get('product_id') }}">
                            <v-select class="form-control" v-model="old_product_values" label="name" :filterable="false" :options="options" @search="searchProduct">
                                <template slot="no-options">
                                    {{ __("Ingresa el nombre del producto...") }}
                                </template>
                            </v-select>
                            <input type="hidden" name="product" id="product" :value="(old_product_values) ? old_product_values.name : '' ">
                            <input type="hidden" name="product_id" id="product_id" :value="(old_product_values) ? old_product_values.id : '' ">
                        </div>
                    </div>
                    <div class="form-group row">
                        @can('viewAny', App\Entities\Client::class)
                            <div class="col">
                                <label>{{ __("Cliente") }}</label>
                                <input type="hidden" id="old_client_fullname" name="old_client_fullname" value="{{ $request->get('client') }}">
                                <input type="hidden" id="old_client_id" name="old_client_id" value="{{ $request->get('client_id') }}">
                                <v-select class="form-control" v-model="old_client_values" label="fullname" :filterable="false" :options="options" @search="searchClient">
                                    <template slot="no-options">
                                        {{ __("Ingresa el nombre del cliente...") }}
                                    </template>
                                </v-select>
                                <input type="hidden" name="client" id="client" :value="(old_client_values) ? old_client_values.fullname : '' ">
                                <input type="hidden" name="client_id" id="client_id" :value="(old_client_values) ? old_client_values.id : '' ">
                            </div>
                        @endcan
                        @can('viewAny', App\Entities\User::class)
                            <div class="col">
                                <label>{{ __("Vendedor") }}</label>
                                <input type="hidden" id="old_user_fullname" name="old_user_fullname" value="{{ $request->get('user') }}">
                                <input type="hidden" id="old_created_by" name="old_created_by" value="{{ $request->get('created_by') }}">
                                <v-select class="form-control" v-model="old_user_values" label="fullname" :filterable="false" :options="options" @search="searchUser">
                                    <template slot="no-options">
                                        {{ __("Ingresa el nombre del vendedor...") }}
                                    </template>
                                </v-select>
                                <input type="hidden" name="user" id="user" :value="(old_user_values) ? old_user_values.fullname : '' ">
                                <input type="hidden" name="created_by" id="created_by" :value="(old_user_values) ? old_user_values.id : '' ">
                            </div>
                        @endcan
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="state">{{ __("Estado") }}</label>
                            <select id="state" name="state" class="form-control">
                                <option value="">--</option>
                                <option value="paid" {{ $request->get('state') == "paid" ? 'selected' : ''}}>{{ __("Pagada") }}</option>
                                <option value="expired" {{ $request->get('state') == "expired" ? 'selected' : ''}}>{{ __("Vencida") }}</option>
                                <option value="pending" {{ $request->get('state') == "pending" ? 'selected' : ''}}>{{ __("Pendiente") }}</option>
                                <option value="annulled" {{ $request->get('state') == "annulled" ? 'selected' : ''}}>{{ __("Anulada") }}</option>
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
