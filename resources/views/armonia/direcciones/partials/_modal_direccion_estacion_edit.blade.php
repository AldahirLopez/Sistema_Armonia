<div class="modal fade" id="editEstacionModal" tabindex="-1" role="dialog" aria-labelledby="editEstacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editEstacionModalLabel">Editar Dirección de Estación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario con el 'action' dinámico -->
                <form id="direccion_estacionForm" method="POST">
                    @csrf
                    @method('PUT') 
                    <input type="hidden" name="direccionSelect" value="estacion">
                    <input type="hidden" name="estacion_id" value="{{ $estacion->id }}">
                    <input type="hidden" id="direccion_estacion_id">

                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <!-- Entidad Federativa (no editable) -->
                            <div class="mb-3">
                                <label for="entidad_federativa_estacion_edit" class="form-label">Entidad Federativa</label>
                                <input type="text" class="form-control" id="entidad_federativa_estacion_edit" disabled>
                                <input type="hidden" name="entidad_federativa_estacion" id="entidad_federativa_estacion_edit">
                            </div>

                            <!-- Municipio -->
                            <div class="mb-3">
                                <label for="municipio_id_estacion_edit" class="form-label">Municipio</label>
                                <select name="municipio_id_estacion" id="municipio_id_estacion_edit" class="form-select" required>
                                    <option value="">Seleccionar municipio</option>
                                </select>
                            </div>

                            <!-- Calle -->
                            <div class="mb-3">
                                <label for="calle_estacion_edit" class="form-label">Calle</label>
                                <input type="text" name="calle_estacion" id="calle_estacion_edit" class="form-control" placeholder="Calle" required>
                            </div>

                            <!-- Número Exterior -->
                            <div class="mb-3">
                                <label for="numero_ext_estacion_edit" class="form-label">Número Exterior</label>
                                <input type="text" name="numero_ext_estacion" id="numero_ext_estacion_edit" class="form-control" placeholder="Número Exterior" required>
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <!-- Número Interior -->
                            <div class="mb-3">
                                <label for="numero_int_estacion_edit" class="form-label">Número Interior</label>
                                <input type="text" name="numero_int_estacion" id="numero_int_estacion_edit" class="form-control" placeholder="Número Interior">
                            </div>

                            <!-- Colonia -->
                            <div class="mb-3">
                                <label for="colonia_estacion_edit" class="form-label">Colonia</label>
                                <input type="text" name="colonia_estacion" id="colonia_estacion_edit" class="form-control" placeholder="Colonia" required>
                            </div>

                            <!-- Código Postal -->
                            <div class="mb-3">
                                <label for="codigo_postal_estacion_edit" class="form-label">Código Postal</label>
                                <input type="text" name="codigo_postal_estacion" id="codigo_postal_estacion_edit" class="form-control" placeholder="Código Postal" required>
                            </div>

                            <!-- Entre Calles -->
                            <div class="mb-3">
                                <label for="entre_calles_estacion_edit" class="form-label">Entre Calles</label>
                                <input type="text" name="entre_calles_estacion" id="entre_calles_estacion_edit" class="form-control" placeholder="Entre Calles" required>
                            </div>

                            <!-- Localidad -->
                            <div class="mb-3">
                                <label for="localidad_estacion_edit" class="form-label">Localidad</label>
                                <input type="text" name="localidad_estacion" id="localidad_estacion_edit" class="form-control" placeholder="Localidad" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>