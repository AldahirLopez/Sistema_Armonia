@if ($direccionFiscal)
<h4>Dirección Fiscal</h4>
<table class="table mb-0">
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
            <td>{{ $direccionFiscal->entidad_federativa ?: '--' }}</td>
            <td>{{ $direccionFiscal->municipio ?: '--' }}</td>
            <td>{{ $direccionFiscal->calle ?: '--' }}</td>
            <td>{{ $direccionFiscal->entre_calles ?: '--' }}</td>
            <td>{{ $direccionFiscal->numero_exterior ?: '--' }}</td>
            <td>{{ $direccionFiscal->numero_interior ?: '--' }}</td>
            <td>{{ $direccionFiscal->colonia ?: '--' }}</td>
            <td>{{ $direccionFiscal->codigo_postal ?: '--' }}</td>
            <td>{{ $direccionFiscal->localidad ?: '--' }}</td>
            <td>
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
@else
<p>No hay dirección fiscal registrada.</p>
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFiscalModal">Agregar Dirección Fiscal</button>
@endif