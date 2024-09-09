<div class="modal fade" id="addFiscalModal" tabindex="-1" role="dialog" aria-labelledby="addFiscalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addFiscalModalLabel">Agregar Dirección Fiscal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('guardar.direccion') }}" method="POST">
                    @csrf
                    <input type="hidden" name="direccionSelect" value="fiscal">
                    <input type="hidden" name="estacion_id" value="{{ $estacion->id }}">
                    @include('armonia.direcciones.partials._form_direccion_fiscal') <!-- Incluir el formulario parcial -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
