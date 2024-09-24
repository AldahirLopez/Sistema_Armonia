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
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <!-- Entidad Federativa -->
                            <div class="mb-3">
                                <label for="entidad_federativa_fiscal" class="form-label">Entidad Federativa</label>
                                <select name="entidad_federativa_fiscal" id="entidad_federativa_fiscal" class="form-select">
                                    <option value="">Seleccionar estado</option>
                                    @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Municipio -->
                            <div class="mb-3">
                                <label for="municipio_fiscal" class="form-label">Municipio</label>
                                <select name="municipio_fiscal" id="municipio_fiscal" class="form-select" required>
                                    <option value="">Seleccionar municipio</option>
                                    <!-- Los municipios se cargarán dinámicamente según el estado seleccionado -->
                                </select>
                            </div>

                            <!-- Calle -->
                            <div class="mb-3">
                                <label for="calle_fiscal" class="form-label">Calle</label>
                                <input type="text" name="calle_fiscal" id="calle_fiscal" class="form-control" placeholder="Calle" required>
                            </div>

                            <!-- Número Exterior -->
                            <div class="mb-3">
                                <label for="numero_exterior_fiscal" class="form-label">Número Exterior</label>
                                <input type="text" name="numero_exterior_fiscal" id="numero_exterior_fiscal" class="form-control" placeholder="Número Exterior" required>
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <!-- Número Interior -->
                            <div class="mb-3">
                                <label for="numero_interior_fiscal" class="form-label">Número Interior</label>
                                <input type="text" name="numero_interior_fiscal" id="numero_interior_fiscal" class="form-control" placeholder="Número Interior">
                            </div>

                            <!-- Colonia -->
                            <div class="mb-3">
                                <label for="colonia_fiscal" class="form-label">Colonia</label>
                                <input type="text" name="colonia_fiscal" id="colonia_fiscal" class="form-control" placeholder="Colonia" required>
                            </div>

                            <!-- Código Postal -->
                            <div class="mb-3">
                                <label for="codigo_postal_fiscal" class="form-label">Código Postal</label>
                                <input type="text" name="codigo_postal_fiscal" id="codigo_postal_fiscal" class="form-control" placeholder="Código Postal" required>
                            </div>

                            <!-- Entre Calles -->
                            <div class="mb-3">
                                <label for="entre_calles_fiscal" class="form-label">Entre Calles</label>
                                <input type="text" name="entre_calles_fiscal" id="entre_calles_fiscal" class="form-control" placeholder="Entre Calles">
                            </div>

                            <!-- Localidad -->
                            <div class="mb-3">
                                <label for="localidad_fiscal" class="form-label">Localidad</label>
                                <input type="text" name="localidad_fiscal" id="localidad_fiscal" class="form-control" placeholder="Localidad">
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