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


        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $direccionFiscal->entidad_federativa }}</td>
            <td>{{ $direccionFiscal->municipio }}</td>
            <td>{{ $direccionFiscal->calle }}</td>
            <td>{{ $direccionFiscal->entre_calles }}</td>
            <td>{{ $direccionFiscal->numero_exterior }}</td>
            <td>{{ $direccionFiscal->numero_interior }}</td>
            <td>{{ $direccionFiscal->colonia }}</td>
            <td>{{ $direccionFiscal->codigo_postal }}</td>
            <td>{{ $direccionFiscal->localidad }}</td>
        </tr>
    </tbody>
</table>
@else
<p>No hay dirección fiscal registrada.</p>
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFiscalModal">Agregar Dirección Fiscal</button>
@endif