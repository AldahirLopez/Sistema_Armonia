<form id="generateExpedienteForm" action="{{ route('expediente.generar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Campos ocultos -->
    <input type="hidden" name="nomenclatura" value="{{ $servicioAnexo->nomenclatura }}">
    <input type="hidden" name="idestacion" value="{{ $estacion->id }}">
    <input type="hidden" name="id_servicio" value="{{ $servicioAnexo->id }}">
    <input type="hidden" name="id_usuario" value="{{ $servicioAnexo->id_usuario }}">
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
                <input type="date" name="fecha_recepcion" id="fecha_recepcion" class="form-control" required value="{{ \Carbon\Carbon::parse($servicioAnexo->date_recepcion_at)->format('Y-m-d') }}">
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
                <input type="date" name="fecha_inspeccion" id="fecha_inspeccion" class="form-control" required value="{{ \Carbon\Carbon::parse($servicioAnexo->date_inspeccion_at)->format('Y-m-d') }}">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Insert CSS directly into the document to style weekends and occupied days
        const style = document.createElement('style');
        style.textContent = `
        /* Make weekends opaque */
        .weekend {
            opacity: 0.5;
        }
        /* Make occupied dates red */
        .occupied-day {
            background-color: red !important;
            color: white;
        }
    `;
        document.head.appendChild(style);

        // Get occupied dates from the backend and format them to 'YYYY-MM-DD'
        const fechasOcupadas = @json($fechasOcupadas).map(f => {
            return {
                fecha: f.fecha.split(' ')[0], // Remove the time component
                nomenclatura: f.nomenclatura
            };
        });

        // Log to verify the formatted fechasOcupadas
       // console.log('Fechas Ocupadas (formatted):', fechasOcupadas);

        // Initialize Flatpickr on both date fields
        flatpickr("#fecha_recepcion, #fecha_inspeccion", {
            dateFormat: "Y-m-d",
            disable: [
                function(date) {
                    // Disable weekends
                    return (date.getDay() === 0 || date.getDay() === 6);
                },
                // Disable occupied dates
                ...fechasOcupadas.map(f => f.fecha)
            ],
            // Customize styling for non-selectable days
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                const dateStr = dayElem.dateObj.toISOString().split('T')[0]; // Convert date to 'YYYY-MM-DD'

                // Make weekends opaque
                if (dayElem.dateObj.getDay() === 0 || dayElem.dateObj.getDay() === 6) {
                    dayElem.classList.add('weekend');
                }

                // Check and style occupied dates
                const fechaOcupada = fechasOcupadas.find(f => f.fecha === dateStr);
                //console.log('Checking date:', dateStr, ' - Found:', fechaOcupada); // Debug each date check
                if (fechaOcupada) {
                    dayElem.classList.add('occupied-day');
                }
            },
            // Set default date to the current date
            defaultDate: new Date().toISOString().split('T')[0]
        });
    });
</script>