<!-- Modal para Generar Certificado -->
<div class="modal fade" id="dictamenesModalcertificado" tabindex="-1" role="dialog" aria-labelledby="dictamenesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="dictamenesModalLabel">GENERAR CERTIFICADO</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="generateCertificadoForm" action="{{ route('guardar.certificado') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Campos ocultos -->
                    <input type="hidden" id="nomenclatura" name="nomenclatura" value="{{ strtoupper($servicioAnexo->nomenclatura) }}">
                    <input type="hidden" id="idestacion" name="idestacion" value="{{ strtoupper($estacion->id) }}">
                    <input type="hidden" id="id_servicio" name="id_servicio" value="{{ $servicioAnexo->id }}">
                    <input type="hidden" name="id_usuario" value="{{ $estacion->usuario->id }}">

                    <!-- RFC del Representante Legal -->
                    <div class="form-group mt-3">
                        <label for="RfcRepresentanteLegal">RFC del Representante Legal:</label>
                        <input type="text" class="form-control" id="RfcRepresentanteLegal" name="RfcRepresentanteLegal" value="{{ $estacion->rfc }}" required>
                        @error('RfcRepresentanteLegal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- RFC del Personal -->
                    <div class="form-group mt-3">
                        <label for="RfcPersonal">RFC del Personal:</label>
                        <input type="text" class="form-control" id="RfcPersonal" name="RfcPersonal" required>
                        @error('RfcPersonal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nota sobre la modificación de la dirección -->
                    <p class="text-danger mb-3">* Si necesita modificar la dirección, por favor vaya a la sección de Estaciones de Servicio.</p>

                    <!-- Dirección precargada (solo lectura y oscurecida) -->
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="calle">Calle:</label>
                                    <input type="text" name="calle" id="calle" class="form-control" value="{{ $direccionEstacion->calle ?? '' }}" readonly style="background-color: #e9ecef;">
                                </div>
                                <div class="form-group">
                                    <label for="numero_exterior">Número y/o Letra Exterior:</label>
                                    <input type="text" name="numero_exterior" id="numero_exterior" class="form-control" value="{{ $direccionEstacion->numero_exterior ?? '' }}" readonly style="background-color: #e9ecef;">
                                </div>
                                <div class="form-group">
                                    <label for="numero_interior">Número y/o Letra Interior:</label>
                                    <input type="text" name="numero_interior" id="numero_interior" class="form-control" value="{{ $direccionEstacion->numero_interior ?? '' }}" readonly style="background-color: #e9ecef;">
                                </div>
                                <div class="form-group">
                                    <label for="colonia">Colonia:</label>
                                    <input type="text" name="colonia" id="colonia" class="form-control" value="{{ $direccionEstacion->colonia ?? '' }}" readonly style="background-color: #e9ecef;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="codigo_postal">Código Postal:</label>
                                    <input type="text" name="codigo_postal" id="codigo_postal" class="form-control" value="{{ $direccionEstacion->codigo_postal ?? '' }}" readonly style="background-color: #e9ecef;">
                                </div>

                                <!-- Selección de Entidad Federativa (Estado) -->
                                <div class="form-group">
                                    <label for="entidad_federativa">Entidad Federativa:</label>
                                    <input type="text" name="entidad_federativa" id="entidad_federativa" class="form-control" value="{{ $direccionEstacion->entidad_federativa ?? '' }}" readonly style="background-color: #e9ecef;">
                                </div>

                                <!-- Selección de Municipio/Alcaldía -->
                                <div class="form-group">
                                    <label for="municipio_alcaldia">Municipio/Alcaldía:</label>
                                    <input type="text" name="municipio_alcaldia" id="municipio_alcaldia" class="form-control" value="{{ $direccionEstacion->municipio ?? '' }}" readonly style="background-color: #e9ecef;">
                                </div>

                                <!-- Localidad -->
                                <div class="form-group">
                                    <label for="localidad">Localidad:</label>
                                    <input type="text" name="localidad" id="localidad" class="form-control" value="{{ $direccionEstacion->localidad ?? '' }}" readonly style="background-color: #e9ecef;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón para generar el certificado -->
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary btn-generar">Generar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>