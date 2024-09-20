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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <!-- Botón de regreso -->
                    <a href="{{ route('estaciones.index') }}" class="btn btn-danger">
                        <i class="bx bx-arrow-back"></i>
                    </a>

                    <!-- Filtro por estado -->
                    <form method="GET" action="{{ route('estaciones.disponibles') }}" class="d-flex align-items-center">
                        <label for="filtroEstado" class="me-2">Filtrar por Estado:</label>
                        <select name="estado" id="filtroEstado" class="form-select w-auto" onchange="this.form.submit()">
                            <option value="">Todos los Estados</option>
                            @foreach($estados as $estado)
                            <option value="{{ $estado->description }}" {{ request('estado') == $estado->description ? 'selected' : '' }}>
                                {{ $estado->description }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Input para buscar estaciones -->
                <div class="mb-4">
                    <input type="text" id="buscarEstacion" class="form-control" placeholder="Buscar estación por número, razón social o estado...">
                </div>

                <!-- Tabla de estaciones -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-dark">
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