<div class="modal fade" id="dictamenesModalmedicion" tabindex="-1" role="dialog" aria-labelledby="dictamenesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="dictamenesModalLabel">TABLA DE CUMPLIMIENTO SISTEMAS DE MEDICIÓN</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="generateWordDicForm" action="{{ route('expediente.dictamenes.medicion') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Campos ocultos -->
                    <input type="hidden" id="nomenclatura" name="nomenclatura" value="{{ strtoupper($servicioAnexo->nomenclatura) }}">
                    <input type="hidden" id="nom_repre" name="nom_repre" value="{{ strtoupper($estacion->nombre_representante_legal) }}">
                    <input type="hidden" id="idestacion" name="idestacion" value="{{ strtoupper($estacion->id) }}">
                    <input type="hidden" id="id_servicio" name="id_servicio" value="{{ $servicioAnexo->id }}">
                    <input type="hidden" name="id_usuario" value="{{ $servicioAnexo->id_usuario  }}">
                    <input type="hidden" name="fecha_actual" value="{{ date('d/m/Y') }}">
                    <input type="hidden" id="numestacion" name="numestacion" value="{{ $estacion->num_estacion }}">

                    <!-- Tabla de especificaciones -->
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Especificación o requerimiento</th>
                                <th>Opinión de cumplimiento</th>
                                <th>Detalle de la opinión (Hallazgos)</th>
                                <th>Recomendaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach([['Requerimiento general del sistema de medición', 'opcion1'],
                            ['Requerimiento de los sistemas de medición estática', 'opcion2'],
                            ['Requerimiento de los sistemas de medición dinámica en ductos', 'opcion3'],
                            ['Requerimientos de los sistemas de medición dinámica en estaciones de servicio', 'opcion4']] as [$requerimiento, $opcion])
                            <tr>
                                <td>{{ $requerimiento }}</td>
                                <td>
                                    @foreach(['cumple', 'no_cumple', 'no_aplica'] as $value)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{ $opcion }}" id="{{ $opcion }}_{{ $value }}" value="{{ $value }}" {{ $value === 'cumple' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="{{ $opcion }}_{{ $value }}">{{ ucfirst($value) }}</label>
                                    </div>
                                    @endforeach
                                </td>
                                <td>
                                    <input class="form-control" name="detalleOpinion{{ $loop->index + 1 }}" placeholder="Detalle de la opinión">
                                </td>
                                <td>
                                    <input class="form-control" name="recomendaciones{{ $loop->index + 1 }}" placeholder="Recomendaciones">
                                </td>
                            </tr>
                            @endforeach
                            <!-- Resultado de la inspección -->
                            <tr>
                                <td colspan="4" class="text-center">
                                    <strong>Resultado de la inspección</strong><br>
                                    @foreach(['cumple', 'no_cumple'] as $value)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="opcion6" id="opcion6_{{ $value }}" value="{{ $value }}" {{ $value === 'cumple' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="opcion6_{{ $value }}">{{ ucfirst($value) }}</label>
                                    </div>
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary btn-generar">Generar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>