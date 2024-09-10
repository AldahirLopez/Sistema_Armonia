<div class="modal fade" id="addEstacionModal" tabindex="-1" role="dialog" aria-labelledby="addEstacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addEstacionModalLabel">Agregar Dirección de Estación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('guardar.direccion') }}" method="POST">
                    @csrf
                    <input type="hidden" name="direccionSelect" value="estacion">
                    <input type="hidden" name="estacion_id" value="{{ $estacion->id }}">
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <!-- Entidad Federativa (no editable) -->
                            <div class="mb-3">
                                <label for="entidad_federativa_estacion" class="form-label">Entidad Federativa</label>
                                <input type="text" class="form-control" value="{{ $estacion->estado_republica }}" disabled>
                                <input type="hidden" name="entidad_federativa_estacion" id="entidad_federativa_estacion" value="{{ $estacion->estado_republica }}">
                            </div>

                            <!-- Municipio -->
                            <div class="mb-3">
                                <label for="municipio_id_estacion" class="form-label">Municipio</label>
                                <select name="municipio_id_estacion" id="municipio_id_estacion" class="form-select" required>
                                    <option value="">Seleccionar municipio</option>
                                    @foreach($municipios as $municipio)
                                    <option value="{{ $municipio->description }}">{{ $municipio->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Calle -->
                            <div class="mb-3">
                                <label for="calle_estacion" class="form-label">Calle</label>
                                <input type="text" name="calle_estacion" id="calle_estacion" class="form-control" placeholder="Calle" required>
                            </div>

                            <!-- Número Exterior -->
                            <div class="mb-3">
                                <label for="numero_ext_estacion" class="form-label">Número Exterior</label>
                                <input type="text" name="numero_ext_estacion" id="numero_ext_estacion" class="form-control" placeholder="Número Exterior" required>
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <!-- Número Interior -->
                            <div class="mb-3">
                                <label for="numero_int_estacion" class="form-label">Número Interior</label>
                                <input type="text" name="numero_int_estacion" id="numero_int_estacion" class="form-control" placeholder="Número Interior">
                            </div>

                            <!-- Colonia -->
                            <div class="mb-3">
                                <label for="colonia_estacion" class="form-label">Colonia</label>
                                <input type="text" name="colonia_estacion" id="colonia_estacion" class="form-control" placeholder="Colonia" required>
                            </div>

                            <!-- Código Postal -->
                            <div class="mb-3">
                                <label for="codigo_postal_estacion" class="form-label">Código Postal</label>
                                <input type="text" name="codigo_postal_estacion" id="codigo_postal_estacion" class="form-control" placeholder="Código Postal" required>
                            </div>

                            <!-- Entre Calles -->
                            <div class="mb-3">
                                <label for="entre_calles_estacion" class="form-label">Entre Calles</label>
                                <input type="text" name="entre_calles_estacion" id="entre_calles_estacion" class="form-control" placeholder="Entre Calles" required>
                            </div>

                            <!-- Localidad -->
                            <div class="mb-3">
                                <label for="localidad_estacion" class="form-label">Localidad</label>
                                <input type="text" name="localidad_estacion" id="localidad_estacion" class="form-control" placeholder="Localidad" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>