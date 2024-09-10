@if ($direccionEstacion)
<h4 class="mt-4">Dirección de Estación</h4>
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
            <td>{{ $direccionEstacion->entidad_federativa }}</td>
            <td>{{ $direccionEstacion->municipio }}</td>
            <td>{{ $direccionEstacion->calle }}</td>
            <td>{{ $direccionEstacion->entre_calles }}</td>
            <td>{{ $direccionEstacion->numero_exterior }}</td>
            <td>{{ $direccionEstacion->numero_interior }}</td>
            <td>{{ $direccionEstacion->colonia }}</td>
            <td>{{ $direccionEstacion->codigo_postal }}</td>
            <td>{{ $direccionEstacion->localidad }}</td>
            <td>

                <!-- Botón de eliminar -->
                <form action="{{ route('direcciones.destroy', $direccionEstacion->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta dirección?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </td>
        </tr>
    </tbody>
</table>
@else
<p>No hay dirección de estación registrada.</p>
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEstacionModal">Agregar Dirección de Estación</button>
@endif