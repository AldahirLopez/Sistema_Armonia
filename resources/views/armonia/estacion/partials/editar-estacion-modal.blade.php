<div class="modal fade" id="editarEstacionModal-{{ $estacion->id }}" tabindex="-1" role="dialog" aria-labelledby="editarEstacionLabel-{{ $estacion->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editarEstacionLabel-{{ $estacion->id }}">
                    <i class="bx bx-edit"></i> Editar Estación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('estaciones.update', $estacion->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tipo_estacion">Tipo de servicio</label>
                                <select name="tipo_estacion" id="tipo_estacion" class="form-select" required>
                                    <option value="" disabled {{ is_null($estacion->tipo_estacion) ? 'selected' : '' }}>Seleccione el tipo de servicio</option>
                                    <option value="Areas_contractuales_asignaciones" {{ $estacion->tipo_estacion == 'Areas_contractuales_asignaciones' ? 'selected' : '' }}>Áreas contractuales y asignaciones</option>
                                    <option value="Estaciones_de_Proceso" {{ $estacion->tipo_estacion == 'Estaciones_de_Proceso' ? 'selected' : '' }}>Estaciones de Proceso</option>
                                    <option value="Produccion_petroliferos" {{ $estacion->tipo_estacion == 'Produccion_petroliferos' ? 'selected' : '' }}>Producción de petrolíferos</option>
                                    <option value="Terminales_almacenamiento" {{ $estacion->tipo_estacion == 'Terminales_almacenamiento' ? 'selected' : '' }}>Terminales de almacenamiento y áreas de almacenamiento para usos propios</option>
                                    <option value="Transporte_distribucion" {{ $estacion->tipo_estacion == 'Transporte_distribucion' ? 'selected' : '' }}>Transporte y distribución</option>
                                    <option value="Comercializacion" {{ $estacion->tipo_estacion == 'Comercializacion' ? 'selected' : '' }}>Comercialización</option>
                                    <option value="Estaciones_de_Servicio" {{ $estacion->tipo_estacion == 'Estaciones_de_Servicio' ? 'selected' : '' }}>Estaciones de Servicio</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="numestacion">Número de estación</label>
                                <input type="text" name="numestacion" class="form-control" value="{{ $estacion->num_estacion }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="razonsocial">Razón Social</label>
                                <input type="text" name="razonsocial" class="form-control" value="{{ $estacion->razon_social }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="rfc">RFC</label>
                                <input type="text" name="rfc" class="form-control" value="{{ $estacion->rfc }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="fecha_apertura">Fecha de apertura</label>
                                <input type="date" name="fecha_apertura" class="form-control" required value="{{ $estacion->fecha_apertura }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" value="{{ $estacion->telefono }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="correo">Correo Electrónico</label>
                                <input type="email" name="correo" class="form-control" value="{{ $estacion->correo_electronico }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="repre">Representante Legal</label>
                                <input type="text" name="repre" class="form-control" value="{{ $estacion->nombre_representante_legal }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="estado">Estado</label>
                                <select name="estado" class="form-select" id="estado" required>
                                    @foreach($estados as $estado)
                                    <option value="{{$estado->description}}" {{ $estacion->estado_republica == $estado->description ? 'selected' : '' }}>
                                        {{ $estado->description }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>