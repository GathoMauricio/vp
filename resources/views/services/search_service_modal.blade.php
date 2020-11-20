<!-- Modal search service-->
<div class="modal fade" id="search_service_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscar servicios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('search_service') }}" method="GET">
                <div class="modal-body">
                    <h6>Seleccione los parámetros de la busqueda</h6>
                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <label class="font-weight-bold">Fecha desde</label>
                                <input name="date1" type="date" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="font-weight-bold">Fecha hasta</label>
                                <input name="date2" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                @php $customers = \App\Customer::all(); @endphp
                                <label class="font-weight-bold">Cliente</label>
                                <select onchange="cargarUsuariosFinalesSearch(this.value);" name="customer_id" type="date" class="form-control">
                                    <option value>--Seleccione una opción--</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" id="ruta_cargar_usuario_final"
                                value="{{ route('cargar_usuario_final') }}">
                                <label class="font-weight-bold">Usuario final</label>
                                <select id="cbo_usuario_final_search"  name="final_user_id" class="form-control">
                                    <option value>--Seleccione una opción--</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                
                                <label class="font-weight-bold">Estatus</label>
                                <select name="status_service_id" class="form-control">
                                    <option value>--Seleccione una opción--</option>
                                    <option value="1">Pendientes</option>
                                    <option value="2">Enproceso</option>
                                    <option value="3">Finalizados</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </form>
        </div>
    </div>
</div>