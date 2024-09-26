<form id="generateExpedienteForm" action="{{ route('reporte_fotografico_servicio_005.generar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Campos ocultos -->

    <input type="hidden" name="nomenclatura" value="{{ $servicio_005->nomenclatura }}">
    <input type="hidden" name="idestacion" value="{{ $estacion->id }}">
    <input type="hidden" name="id_servicio" value="{{ $servicio_005->id }}">
    <input type="hidden" name="id_usuario" value="{{ $servicio_005->id_usuario}}">
    <input type="hidden" name="domicilio_servicio_id" value="{{ $estacion->domicilio_servicio_id }}">
    <input type="hidden" name="fecha_inspeccion" class="form-control" value="{{ \Carbon\Carbon::parse($servicio_005->date_inspeccion_at)->format('Y-m-d') }}">
  
    <div class="row">
        <!-- Sección para subir varias imágenes -->
        <div class="col-md-12">
            <div class="form-group">
                <label for="imagenes">Subir Imágenes</label>
                <input type="file" name="imagenes[]" class="form-control" id="imagenes" accept="image/*" multiple required>
                <small class="form-text text-muted">Debe subir al menos 4 imágenes.De lo contrario no se actualizara su reporte</small>
            </div>
        </div>
    </div>
    <!-- Botón para enviar el formulario -->
    <button type="submit" class="btn btn-primary mt-3">Generar</button>
</form>