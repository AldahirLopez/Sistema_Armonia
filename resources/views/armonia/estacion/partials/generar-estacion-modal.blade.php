<div class="modal fade" id="generarEstacionModal" tabindex="-1" role="dialog" aria-labelledby="generarEstacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="generarEstacionLabel">
                    <i class="bx bx-plus"></i> Generar Nueva Estación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="generarEstacionForm" action="{{ route('estaciones.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tipo_estacion">Tipo de servicio</label>
                                <select name="tipo_estacion" id="tipo_estacion" class="form-select" required>
                                    <option value="" disabled selected>Seleccione el tipo de servicio</option>
                                    <option value="Areas_contractuales_asignaciones">Áreas contractuales y asignaciones</option>
                                    <option value="Estaciones_de_Proceso">Estaciones de Proceso</option>
                                    <option value="Produccion_petroliferos">Producción de petrolíferos</option>
                                    <option value="Terminales_almacenamiento">Terminales de almacenamiento y áreas de almacenamiento para usos propios</option>
                                    <option value="Transporte_distribucion">Transporte y distribución</option>
                                    <option value="Comercializacion">Comercialización</option>
                                    <option value="Estaciones_de_Servicio">Estaciones de Servicio</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="numestacion">Número de estación</label>
                                <input type="text" name="numestacion" class="form-control" required value="{{ old('numestacion') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="razonsocial">Razón Social</label>
                                <input type="text" name="razonsocial" class="form-control" required value="{{ old('razonsocial') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="rfc">RFC</label>
                                <input type="text" name="rfc" class="form-control" required value="{{ old('rfc') }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="fecha_apertura">Fecha de apertura</label>
                                <input type="date" name="fecha_apertura" class="form-control" required value="{{ old('fecha_apertura') }}">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" required value="{{ old('telefono') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="correo">Correo Electrónico</label>
                                <input type="email" name="correo" class="form-control" required value="{{ old('correo') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="repre">Representante Legal</label>
                                <input type="text" name="repre" class="form-control" required value="{{ old('repre') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="estado">Estado</label>
                                <select name="estado" class="form-select" id="estado" required>
                                    <option value="" selected disabled>Selecciona un estado</option>
                                    @foreach($estados as $estado)
                                    <option value="{{ $estado->description }}">{{ $estado->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success">Generar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>