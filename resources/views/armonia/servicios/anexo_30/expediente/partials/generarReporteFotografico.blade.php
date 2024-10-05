<form id="generarReporteFotografico" action="{{ route('reporte_fotografico_anexo_30.generar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Hidden Fields -->
    <input type="hidden" name="nomenclatura" value="{{ $servicioAnexo->nomenclatura }}">
    <input type="hidden" name="idestacion" value="{{ $estacion->id }}">
    <input type="hidden" name="id_servicio" value="{{ $servicioAnexo->id }}">
    <input type="hidden" name="id_usuario" value="{{ $servicioAnexo->id_usuario }}">
    <input type="hidden" name="domicilio_servicio_id" value="{{ $estacion->domicilio_servicio_id }}">
    <input type="hidden" name="fecha_inspeccion" class="form-control" value="{{ \Carbon\Carbon::parse($servicioAnexo->date_inspeccion_at)->format('Y-m-d') }}">

    <!-- Modal Body -->
    <div class="modal-body">
        <!-- Upload Images Section -->
        <div class="mb-4">
            <label for="imagenes" class="form-label">Subir Imágenes</label>
            <input type="file" name="imagenes[]" class="form-control" id="imagenes" accept="image/*" multiple required>
            <small class="text-muted">Debe subir al menos 4 imágenes. De lo contrario, no se actualizará su reporte.</small>
        </div>
    </div>

    <!-- Modal Footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Generar</button>
    </div>
</form>
