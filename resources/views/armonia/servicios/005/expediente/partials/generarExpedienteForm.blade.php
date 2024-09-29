<form id="generateExpedienteForm" action="{{ route('expediente_servicio_005.generar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Campos ocultos -->

    <input type="hidden" name="nomenclatura" value="{{ $servicio_005->nomenclatura }}">
    <input type="hidden" name="idestacion" value="{{ $estacion->id }}">
    <input type="hidden" name="id_servicio" value="{{ $servicio_005->id }}">
    <input type="hidden" name="id_usuario" value="{{ $servicio_005->id_usuario }}">
    <input type="hidden" name="numestacion" value="{{ $estacion->num_estacion }}">

    <div class="row">
        <!-- Columna 1 -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="tipo_estacion">Tipo de Estación</label>
                <input type="text" name="tipo_estacion" class="form-control" value="{{ $estacion->tipo_estacion }}" readonly>
            </div>

            <div class="form-group">
                <label for="num_estacion">Número de Estación</label>
                <input type="text" name="num_estacion" class="form-control" value="{{ $estacion->num_estacion }}" readonly>
            </div>

            <div class="form-group">
                <label for="razonsocial">Razón Social</label>
                <input type="text" name="razon_social" class="form-control" value="{{ $estacion->razon_social }}" readonly>
            </div>

            <div class="form-group">
                <label for="rfc">RFC</label>
                <input type="text" name="rfc" class="form-control" value="{{ $estacion->rfc }}" readonly>
            </div>

            <div class="form-group">
                <label for="estado_republica">Estado de la República</label>
                <input type="text" name="estado_republica" class="form-control" value="{{ $estacion->estado_republica }}" readonly>
            </div>

            <div class="form-group">
                <label for="num_cre">Num. de Permiso de la Comisión Reguladora de Energía (CRE)</label>
                <input type="text" name="num_cre" class="form-control" value="{{ $estacion->num_cre }}">
            </div>

            <div class="form-group">
                <label for="num_constancia">Num. de Constancia</label>
                <input type="text" name="num_constancia" class="form-control" value="{{ $estacion->num_constancia }}">
            </div>

            <!-- Fecha de Recepción de Solicitud -->
            <div class="form-group">
                <label for="fecha_recepcion">Fecha de Recepción de Solicitud</label>
                <input type="date" name="fecha_recepcion" id="fecha_recepcion" class="form-control" required value="{{ \Carbon\Carbon::parse($servicio_005->date_recepcion_at)->format('Y-m-d') }}">
                @error('fecha_recepcion')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Columna 2 -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ $estacion->telefono }}">
            </div>

            <div class="form-group">
                <label for="correo_electronico">Correo Electrónico</label>
                <input type="email" name="correo_electronico" class="form-control" value="{{ $estacion->correo_electronico }}">
            </div>

            <div class="form-group">
                <label for="contacto">Contacto</label>
                <input type="text" name="contacto" class="form-control" value="{{ $estacion->contacto }}">
            </div>

            <div class="form-group">
                <label for="nombre_representante_legal">Nombre del Representante Legal</label>
                <input type="text" name="nombre_representante_legal" class="form-control" value="{{ $estacion->nombre_representante_legal }}">
            </div>

            <div class="form-group">
                <label for="domicilio_fiscal_id">Domicilio Fiscal ID</label>
                <input type="text" name="domicilio_fiscal_id" class="form-control" value="{{ $estacion->domicilio_fiscal_id }}" readonly>
            </div>

            <div class="form-group">
                <label for="domicilio_servicio_id">Domicilio de Servicio ID</label>
                <input type="text" name="domicilio_servicio_id" class="form-control" value="{{ $estacion->domicilio_servicio_id }}" readonly>
            </div>

            <!-- Fecha Programada de Inspección -->
            <div class="form-group">
                <label for="fecha_inspeccion">Fecha Programada de Inspección</label>
                <input type="date" name="fecha_inspeccion" id="fecha_inspeccion" class="form-control" required value="{{ \Carbon\Carbon::parse($servicio_005->date_inspeccion_at)->format('Y-m-d') }}">
                @error('fecha_inspeccion')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" class="form-control" required value="{{ old('cantidad') }}">
            </div>
        </div>
    </div>

    <!-- Botón para enviar el formulario -->
    <button type="submit" class="btn btn-primary mt-3">Generar</button>
</form> 
<!-- Pasar las fechas ocupadas al script -->
<script id="fechasOcupadasAnexo30" type="application/json">@json($fechasOcupadasAnexo30)</script>
<script id="fechasOcupadas005" type="application/json">@json($fechasOcupadas005)</script>

<!-- Incluir el script externo -->
<script src="{{ URL::asset('build/js/form-expediente.js') }}"></script>