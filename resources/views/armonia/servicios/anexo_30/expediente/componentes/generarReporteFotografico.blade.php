
<!-- Modal -->
<div class="modal fade" id="generarReporteFotografico" tabindex="-1" aria-labelledby="generarExpedienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="generarExpedienteModalLabel">Generar Reporte fotografico de ({{ $servicioAnexo->nomenclatura }})</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('armonia.servicios.anexo_30.expediente.partials.generarReporteFotografico')
            </div>
        </div>
    </div>
</div> 