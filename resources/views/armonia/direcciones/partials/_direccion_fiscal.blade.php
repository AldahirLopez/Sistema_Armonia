@if ($direccionFiscal)
<h4 class="mt-4">Dirección Fiscal</h4>

<!-- Contenedor para hacer la tabla responsiva -->
<div class="table-responsive">
    <table class="table table-bordered mb-0">
        <thead class="table-light">
            <tr>
                <th>Entidad Federativa</th>
                <th>Municipio</th>
                <th>Calle</th>
                <th>Entre Calles</th>
                <th>Número Exterior</th>
                <th>Número Interior</th>
                <th>Colonia</th>
                <th>Código Postal</th>
                <th>Localidad</th>
                <th>Acciones</th> <!-- Columna para los botones de acciones -->
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-label="Entidad Federativa">{{ $direccionFiscal->entidad_federativa ?: '--' }}</td>
                <td data-label="Municipio">{{ $direccionFiscal->municipio ?: '--' }}</td>
                <td data-label="Calle">{{ $direccionFiscal->calle ?: '--' }}</td>
                <td data-label="Entre Calles">{{ $direccionFiscal->entre_calles ?: '--' }}</td>
                <td data-label="Número Exterior">{{ $direccionFiscal->numero_exterior ?: '--' }}</td>
                <td data-label="Número Interior">{{ $direccionFiscal->numero_interior ?: '--' }}</td>
                <td data-label="Colonia">{{ $direccionFiscal->colonia ?: '--' }}</td>
                <td data-label="Código Postal">{{ $direccionFiscal->codigo_postal ?: '--' }}</td>
                <td data-label="Localidad">{{ $direccionFiscal->localidad ?: '--' }}</td>
                <td data-label="Acciones">
                    <!-- Botón de eliminar -->
                    <form action="{{ route('direcciones.destroy', $direccionFiscal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta dirección?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@else
<p>No hay dirección fiscal registrada.</p>
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFiscalModal">Agregar Dirección Fiscal</button>
@endif