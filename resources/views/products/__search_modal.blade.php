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
                <form id="searchForm" action="{{ route('products.index') }}" method="get">
                    <div class="form-group row">
                        <div class="col">
                            <label>{{ __("Nombre") }}</label>
                            <input type="hidden" id="old_product_name" name="old_product_name" value="{{ $request->get('product') }}">
                            <input type="hidden" id="old_product_id" name="old_product_id" value="{{ $request->get('product_id') }}">
                            <v-select v-model="old_product_values" label="name" :filterable="false" :options="options" @search="searchProduct"
                                      class="form-control">
                                <template slot="no-options">
                                    {{ __("Ingresa el nombre...") }}
                                </template>
                            </v-select>
                            <input type="hidden" name="product" id="product" :value="(old_product_values) ? old_product_values.name : '' ">
                            <input type="hidden" name="product_id" id="product_id" :value="(old_product_values) ? old_product_values.id : '' ">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
                <button type="submit" form="searchForm" class="btn btn-primary">
                    <i class="fa fa-search"></i> {{ __("Buscar") }}
                </button>
            </div>
        </div>
    </div>
</div>
