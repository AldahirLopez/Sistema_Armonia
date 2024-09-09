@extends('layouts.master') <!-- Usar el layout principal de la plantilla -->

@section('title') Estaciones de Servicio @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Estaciones @endslot
@slot('title') Listado de Estaciones de Servicio @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <!-- Botón de regreso -->
                    <a href="{{ route('estaciones.index') }}" class="btn btn-danger"><i class="bx bx-arrow-back"></i></a>
                </div>

                <!-- Input para buscar estaciones -->
                <input type="text" id="buscarEstacion" class="form-control mb-3" placeholder="Buscar estación...">

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Número de Estación</th>
                            <th scope="col">Razón Social</th>
                            <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody id="tablaEstaciones">
                        @foreach($estaciones as $estacion)
                        <tr>
                            <td>{{ $estacion->num_estacion }}</td>
                            <td>{{ $estacion->razon_social }}</td>
                            <td>{{ $estacion->estado_republica }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('buscarEstacion').addEventListener('input', function() {
        const value = this.value.toLowerCase();
        document.querySelectorAll('#tablaEstaciones tr').forEach(row => {
            const visible = row.textContent.toLowerCase().includes(value);
            row.style.display = visible ? '' : 'none';
        });
    });
</script>

@endsection