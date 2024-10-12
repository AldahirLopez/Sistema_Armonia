<form id="generateExpedienteForm" action="{{ route('comprobante_traslado_anexo_30.generar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Campos ocultos -->
    <input type="hidden" name="nomenclatura" value="{{ $servicioAnexo->nomenclatura }}">
    <input type="hidden" name="idestacion" value="{{ $estacion->id }}">
    <input type="hidden" name="id_servicio" value="{{ $servicioAnexo->id }}">
    <input type="hidden" name="id_usuario" value="{{ $servicioAnexo->id_usuario }}">
    <input type="hidden" name="numestacion" value="{{ $estacion->num_estacion }}">

    <div class="row">

        <!-- Columna 2 -->
        <div class="col-md-6">
             
            <!-- Fecha Programada de Inspección -->
            <div class="form-group">
                <label for="fecha_inspeccion">Fecha Programada de Inspección</label>
                <input type="date" name="fecha_inspeccion" id="fecha_inspeccion" class="form-control" required value="{{ \Carbon\Carbon::parse($servicioAnexo->date_inspeccion_at)->format('Y-m-d') }}">
                @error('fecha_inspeccion')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>


    </div>


    <div class="row">

    <table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="5">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">No.</th>
                            <th class="text-center align-middle">ORIGEN</th>
                            <th class="text-center align-middle">DESTINO</th>
                            <th class="text-center align-middle">TRANSPORTE UTILIZADO</th>
                            <th class="text-center align-middle">TIPO COMPROBANTE</th>
                            <th class="text-center align-middle">CONCEPTO</th>
                            <th class="text-center align-middle">FECHA EMISION</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <tr>
                            <td class="text-center align-middle">1</td>

                            <td class="align-middle text-start">
                                <input type="text" name="origen1" class="form-control">
                            </td>

                            <td class="align-middle text-start">
                                <input type="text" name="destino1" class="form-control">
                            </td>

                            <td class="text-start align-start">
                                <label>
                                    <input class="form-check-input" type="radio" name="trasnporte" value="avion" checked> Avion
                                </label><br>
                                <label>
                                    <input class="form-check-input" type="radio" name="trasnporte" value="autobus">Autobus
                                </label><br>

                                <label>
                                    <input  class="form-check-input" type="radio" name="trasnporte" value="taxi">Taxi
                                </label><br>
                                <label>
                                    <input class="form-check-input" type="radio" name="trasnporte" value="oficial"> Oficial
                                </label><br>

                                <label>
                                    <input class="form-check-input" type="radio" name="trasnporte" value="otro"> Otro
                                </label><br>
                                <input type="text" name="ob1" class="form-control d-inline w-auto ms-2">
                            </td>

                            <td class="text-start align-start">
                                <label>
                                    <input class="form-check-input" type="radio" name="comprobante" value="factura" checked>Factura
                                </label><br>
                                <label>
                                    <input class="form-check-input" type="radio" name="comprobante" value="boleto">Boleto
                                </label><br>

                                <label>
                                    <input class="form-check-input" type="radio" name="comprobante" value="otro"> Otro
                                </label><br>
                                <input type="text" name="ob2" class="form-control d-inline w-auto ms-2">
                              
                            </td>

                            <td class="text-start align-start">
                                <label>
                                    <input class="form-check-input" type="radio" name="concepto" value="pasaje" checked>Pasaje
                                </label><br>
                                <label>
                                    <input class="form-check-input" type="radio" name="concepto" value="caseta">Caseta
                                </label><br>

                                <label>
                                    <input class="form-check-input" type="radio" name="concepto" value="combustible">Combustible
                                </label><br>

                                <label>
                                    <input  class="form-check-input" type="radio" name="concepto" value="otro"> Otro
                                </label><br>
                                <input type="text" name="ob3" class="form-control d-inline w-auto ms-2">
                              
                            </td>

                            <td class="align-middle">
                             <input type="date" name="fecha_emision1" id="fecha_emision1" class="form-control">
                            </td>
                        </tr>



                        <tr>
                            <td class="text-center align-start">2</td>

                            <td class="align-middle text-start">
                                <input type="text" name="origen2" class="form-control">
                            </td>

                            <td class="align-middle text-start">
                                <input type="text" name="destino2" class="form-control">
                            </td>

                            <td class="text-start align-start">
                                <label>
                                    <input class="form-check-input" type="radio" name="trasnporte2" value="avion" checked> Avion
                                </label><br>
                                <label>
                                    <input class="form-check-input" type="radio" name="trasnporte2" value="autobus">Autobus
                                </label><br>

                                <label>
                                    <input class="form-check-input" type="radio" name="trasnporte2" value="taxi">Taxi
                                </label><br>
                                <label>
                                    <input class="form-check-input" type="radio" name="trasnporte2" value="oficial"> Oficial
                                </label><br>

                                <label>
                                    <input class="form-check-input" type="radio" name="trasnporte2" value="otro"> Otro
                                </label><br>
                                <input type="text" name="ob4" class="form-control d-inline w-auto ms-2">
                            </td>

                            <td class="text-start align-start">
                                <label>
                                    <input class="form-check-input" type="radio" name="comprobante2" value="factura" checked>Factura
                                </label><br>
                                <label>
                                    <input class="form-check-input" type="radio" name="comprobante2" value="boleto">Boleto
                                </label><br>

                                <label>
                                    <input class="form-check-input" type="radio" name="comprobante2" value="otro"> Otro
                                </label><br>
                                <input type="text" name="ob5" class="form-control d-inline w-auto ms-2">
                              
                            </td>

                            <td class="text-start align-start">
                                <label>
                                    <input class="form-check-input" type="radio" name="concepto2" value="pasaje" checked>Pasaje
                                </label><br>
                                <label>
                                    <input class="form-check-input" type="radio" name="concepto2" value="caseta">Caseta
                                </label><br>

                                <label>
                                    <input class="form-check-input" type="radio" name="concepto2" value="combustible">Combustible
                                </label><br>

                                <label>
                                    <input class="form-check-input" type="radio" name="concepto2" value="otro"> Otro
                                </label><br>
                                <input type="text" name="ob6" class="form-control d-inline w-auto ms-2">
                              
                            </td>

                            <td class="align-middle">
                             <input type="date" name="fecha_emision2" id="fecha_emision2" class="form-control">
                            </td>
                        </tr>

                       
                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

    </div>





    <!-- Leyenda de advertencia -->
    <div id="warningMessage" class="alert alert-warning mt-3" style="display: none;">
        Registre sus direcciones (fiscal y de servicio) primero.
    </div>

    <!-- Botón para enviar el formulario -->
    <button type="submit" id="generateButton" class="btn btn-primary mt-3">Generar</button>
</form>

<!-- Script para manejar la lógica de habilitar/deshabilitar el botón -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener elementos de las direcciones
        const fiscalId = "{{ $estacion->domicilio_fiscal_id }}";
        const servicioId = "{{ $estacion->domicilio_servicio_id }}";

        // Obtener elementos del formulario
        const generateButton = document.getElementById('generateButton');
        const warningMessage = document.getElementById('warningMessage');

        // Verificar si las direcciones están registradas
        if (!fiscalId || !servicioId) {
            // Si alguna dirección falta, mostrar advertencia y deshabilitar el botón
            generateButton.disabled = true;
            warningMessage.style.display = 'block';
        } else {
            // Si ambas direcciones existen, habilitar el botón
            generateButton.disabled = false;
            warningMessage.style.display = 'none';
        }
    });
</script>

<!-- Pasar las fechas ocupadas al script -->
<script id="fechasOcupadasAnexo30" type="application/json">
    @json($fechasOcupadasAnexo30)
</script>
<script id="fechasOcupadas005" type="application/json">
    @json($fechasOcupadas005)
</script>

<!-- Incluir el script externo -->
<script src="{{ URL::asset('build/js/form-expediente.js') }}"></script>