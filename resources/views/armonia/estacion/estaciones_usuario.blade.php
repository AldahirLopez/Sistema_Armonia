@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Estaciones @endslot
@slot('title') Estaciones de Servicio @endslot
@endcomponent

@include('partials.alertas') <!-- Incluyendo las alertas -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <!-- Filtros y acciones -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <!-- Filtro por estado y búsqueda -->
                    <div class="d-flex align-items-center">
                        <form method="GET" action="{{ route('estaciones.usuario') }}" class="d-flex align-items-center me-3">
                            <label for="filtroEstado" class="me-2">Estado:</label>
                            <select name="estado" id="filtroEstado" class="form-select w-auto me-2">
                                <option value="">Todos</option>
                                @foreach($estados as $estado)
                                <option value="{{ $estado->description }}" {{ request('estado') == $estado->description ? 'selected' : '' }}>
                                    {{ $estado->description }}
                                </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </form>

                        <!-- Input para buscar estaciones -->
                        <input type="text" id="buscarEstacion" class="form-control w-auto" placeholder="Buscar...">
                    </div>

                    <!-- Botón para generar nueva estación -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generarEstacionModal">
                        <i class="fas fa-plus"></i> Nueva Estación
                    </button>
                </div>

                <!-- Tabla de estaciones -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th class="text-nowrap">Número</th>
                                <th class="text-nowrap">Razón Social</th>
                                <th class="text-nowrap">Estado</th>
                                <th class="text-nowrap">Municipio</th>
                                <th class="text-nowrap">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaEstaciones">
                            @foreach($estaciones as $estacion)
                            <tr class="text-center">
                                <td>{{ $estacion->num_estacion }}</td>
                                <td>{{ $estacion->razon_social }}</td>
                                <td>{{ $estacion->estado_republica }}</td>
                                <td>{{ optional($estacion->domicilioServicio)->municipio ?? 'No disponible' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Botón para ver direcciones con tooltip y color personalizado -->
                                        <a href="{{ route('estacion.direcciones', ['id' => $estacion->id]) }}" class="btn btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Direcciones de la estación">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </a>

                                        <!-- Botón para ver estructura con tooltip y color personalizado -->
                                        <a href="{{ route('equipo.seleccion', ['id' => $estacion->id]) }}" class="btn btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Estructura de la estación">
                                            <i class="fas fa-building"></i>
                                        </a>

                                        <!-- Botón para editar con tooltip y color personalizado -->
                                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar estación" data-bs-target="#editarEstacionModal-{{ $estacion->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Botón para eliminar con tooltip y color personalizado -->
                                        @if(auth()->check() && auth()->user()->hasRole('Administrador'))
                                        <form action="{{ route('estaciones.destroy', $estacion->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar estación" onclick="return confirm('¿Eliminar esta estación?');">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>

                                        <a href="{{ route('galeria.show',['id_estacion' => $estacion->id]) }}" class="btn btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Galeria de fotos">
                                            <i class="fas fa-camera"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($estaciones as $estacion)
@include('armonia.estacion.partials.editar-estacion-modal', ['estacion' => $estacion, 'estados' => $estados])
@endforeach

@include('armonia.estacion.partials.generar-estacion-modal', ['estados' => $estados])

<!-- Scripts para funcionalidades adicionales -->
<script>
    document.getElementById('buscarEstacion').addEventListener('input', function() {
        const value = this.value.toLowerCase();
        document.querySelectorAll('#tablaEstaciones tr').forEach(row => {
            const visible = row.textContent.toLowerCase().includes(value);
            row.style.display = visible ? '' : 'none';
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

@endsection