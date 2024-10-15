@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Estaciones @endslot
@slot('title') Estaciones de Servicio @endslot
@endcomponent

@include('partials.alertas')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <!-- Filtros y acciones -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <form method="GET" action="{{ route('estaciones.usuario') }}" class="d-flex w-75">
                        <select name="estado" id="filtroEstado" class="form-select me-2">
                            <option value="">Todos los estados</option>
                            @foreach($estados as $estado)
                            <option value="{{ $estado->description }}" {{ request('estado') == $estado->description ? 'selected' : '' }}>
                                {{ $estado->description }}
                            </option>
                            @endforeach
                        </select>
                        <input type="text" id="buscarEstacion" class="form-control me-2" placeholder="Buscar estación...">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </form>

                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generarEstacionModal">
                        <i class="fas fa-plus"></i> Nueva Estación
                    </button>
                </div>

                <!-- Tabla de estaciones -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-lg align-middle">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th style="width: 10%;">Número</th>
                                <th style="width: 25%;">Razón Social</th>
                                <th style="width: 15%;">Estado</th>
                                <th style="width: 20%;">Municipio</th>
                                <th style="width: 20%;">Antigüedad</th>
                                <th style="width: 30%;">Opciones</th>
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
                                    @if($estacion->fecha_apertura)
                                        {{$estacion->fecha_apertura}}<br>
                                        Antigüedad: {{ \Carbon\Carbon::parse($estacion->fecha_apertura)->diff(now())->y }} años 
                                        y {{ \Carbon\Carbon::parse($estacion->fecha_apertura)->diff(now())->m }} meses
                                    @else
                                        Sin fecha de apertura
                                    @endif
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="opcionesEstacion{{ $estacion->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> Opciones
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="opcionesEstacion{{ $estacion->id }}">
                                            <li>
                                                <a href="{{ route('estacion.direcciones', ['id' => $estacion->id]) }}" class="dropdown-item">
                                                    <i class="fas fa-map-marker-alt"></i> Ver Direcciones
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('equipo.seleccion', ['id' => $estacion->id]) }}" class="dropdown-item">
                                                    <i class="fas fa-building"></i> Ver Estructura
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('galeria.show',['id_estacion' => $estacion->id]) }}" class="dropdown-item">
                                                    <i class="fas fa-camera"></i> Galería de Fotos
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editarEstacionModal-{{ $estacion->id }}">
                                                    <i class="fas fa-edit"></i> Editar
                                                </button>
                                            </li>
                                            @if(auth()->check() && auth()->user()->hasRole('Administrador'))
                                            <li>
                                                <form action="{{ route('estaciones.destroy', $estacion->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta estación?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-trash-alt"></i> Eliminar
                                                    </button>
                                                </form>
                                            </li>
                                            @endif
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

    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

@endsection