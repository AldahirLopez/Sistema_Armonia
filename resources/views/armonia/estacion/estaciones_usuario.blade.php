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
                <!-- Filtros y búsqueda -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <!-- Botón de regreso -->
                    <a href="{{ route('estaciones.index') }}" class="btn btn-danger">
                        <i class="bx bx-arrow-back"></i>
                    </a>

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
                        <i class="bx bx-plus"></i> Nueva Estación
                    </button>
                </div>

                <!-- Tabla de estaciones -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Número</th>
                                <th>Razón Social</th>
                                <th>Estado</th>
                                <th>Municipio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaEstaciones">
                            @foreach($estaciones as $estacion)
                            <tr>
                                <td>{{ $estacion->num_estacion }}</td>
                                <td>{{ $estacion->razon_social }}</td>
                                <td>{{ $estacion->estado_republica }}</td>
                                <td>{{ optional($estacion->domicilioServicio)->municipio ?? 'No disponible' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Acciones
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button type="button" class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#editarEstacionModal-{{ $estacion->id }}">
                                                    <i class="bx bx-pencil"></i> Editar
                                                </button>
                                            </li>
                                            @if(auth()->check() && auth()->user()->hasRole('Administrador'))
                                            <li>
                                                <form action="{{ route('estaciones.destroy', $estacion->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Eliminar esta estación?');">
                                                        <i class="bx bx-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </li>
                                            @endif
                                            <li>
                                                <a href="{{ route('estacion.direcciones', ['id' => $estacion->id]) }}" class="dropdown-item text-info">
                                                    <i class="far fa-map"></i> Direcciones
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('equipo.seleccion', ['id' => $estacion->id]) }}" class="dropdown-item text-info">
                                                    <i class="mdi mdi-office-building-cog"></i> Estructura
                                                </a>
                                            </li>
                                        </ul>
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