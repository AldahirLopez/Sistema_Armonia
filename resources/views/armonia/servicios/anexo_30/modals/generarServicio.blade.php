<!-- Modal para generar servicio -->
<div class="modal fade" id="generarServicioModal" tabindex="-1" role="dialog" aria-labelledby="generarServicioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ffbf539e;color: #ffffff;">
                <h5 class="modal-title" id="generarServicioModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Generar Servicio Anexo 30
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario de generación de expediente -->
                <form id="generarServicioForm" action="{{ route('anexo.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5 class="modal-title" style="padding-top: 10px;">Seleccione una estación a la cual se le anexará su servicio</h5>
                    <div class="row">
                        <!-- Select dentro del formulario -->
                        <div class="form-group" style="padding-top: 10px;">
                            <select name="estacion" class="form-select" id="estacion">
                                <option value="">Selecciona una estación</option>
                                @foreach ($estaciones as $estacion)
                                <option value="{{ $estacion->id }}">{{ $estacion->razon_social }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="padding-top: 10px;">
                        <button type="submit" class="btn btn-success  btn-generar">Generar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>