@extends('layouts.master')

@section('title') @lang('Estaciones de Servicio') @endsection

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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <!-- Botón de regreso -->
                    <a href="{{ route('estaciones.index') }}" class="btn btn-danger">
                        <i class="bx bx-arrow-back"></i>
                    </a>

                    <!-- Filtro por estado -->
                    <form method="GET" action="{{ route('estaciones.usuario') }}" class="d-flex align-items-center">
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

                    <!-- Botón para generar nueva estación -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generarEstacionModal">
                        <i class="bx bx-plus"></i> Nueva Estación
                    </button>
                </div>

                <!-- Input para buscar estaciones -->
                <div class="mb-4">
                    <input type="text" id="buscarEstacion" class="form-control" placeholder="Buscar estación por nombre, número o razón social...">
                </div>

                <!-- Tabla de estaciones -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Tipo de Estacion</th>
                                <th>Número de estación</th>
                                <th>Razón Social</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                                <th>Direcciones</th>
                                <th>Estructura</th>
                            </tr>
                        </thead>
                        <tbody id="tablaEstaciones">
                            @foreach($estaciones as $estacion)
                            <tr>
                                <td>{{ $estacion->tipo_estacion }}</td>
                                <td>{{ $estacion->num_estacion }}</td>
                                <td>{{ $estacion->razon_social }}</td>
                                <td>{{ $estacion->estado_republica }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarEstacionModal-{{ $estacion->id }}">
                                        <i class="bx bx-pencil"></i>
                                    </button>

                                    @if(auth()->check() && auth()->user()->hasRole('Administrador'))
                                    <form action="{{ route('estaciones.destroy', $estacion->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta estación?');" title="Eliminar">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('estacion.direcciones', ['id' => $estacion->id]) }}" class="btn btn-secondary btn-sm">
                                        <i class="far fa-map"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('equipo.seleccion', ['id' => $estacion->id]) }}" class="btn btn-secondary btn-sm">
                                        <i class="mdi mdi-office-building-cog"></i>
                                    </a>
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
<!-- Modal para editar estación -->
<div class="modal fade" id="editarEstacionModal-{{ $estacion->id }}" tabindex="-1" role="dialog" aria-labelledby="editarEstacionLabel-{{ $estacion->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editarEstacionLabel-{{ $estacion->id }}">
                    <i class="bx bx-edit"></i> Editar Estación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('estaciones.update', $estacion->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_estacion">Tipo de servicio</label>
                                <select name="tipo_estacion" id="tipo_estacion" class="form-select" required>
                                    <option value="" disabled {{ is_null($estacion->tipo_estacion) ? 'selected' : '' }}>Seleccione el tipo de servicio</option>
                                    <option value="Transporte" {{ $estacion->tipo_estacion == 'Transporte' ? 'selected' : '' }}>Transporte</option>
                                    <option value="Estacion de servicio" {{ $estacion->tipo_estacion == 'Estacion de servicio' ? 'selected' : '' }}>Estación de servicio</option>
                                    <option value="Almacenamiento" {{ $estacion->tipo_estacion == 'Almacenamiento' ? 'selected' : '' }}>Almacenamiento</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="numestacion">Número de estación</label>
                                <input type="text" name="numestacion" class="form-control" value="{{ $estacion->num_estacion }}" required>
                            </div>
                            <div class="form-group">
                                <label for="razonsocial">Razón Social</label>
                                <input type="text" name="razonsocial" class="form-control" value="{{ $estacion->razon_social }}" required>
                            </div>
                            <div class="form-group">
                                <label for="rfc">RFC</label>
                                <input type="text" name="rfc" class="form-control" value="{{ $estacion->rfc }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" value="{{ $estacion->telefono }}" required>
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo Electrónico</label>
                                <input type="email" name="correo" class="form-control" value="{{ $estacion->correo_electronico }}" required>
                            </div>
                            <div class="form-group">
                                <label for="repre">Representante Legal</label>
                                <input type="text" name="repre" class="form-control" value="{{ $estacion->nombre_representante_legal }}" required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select name="estado" class="form-select" id="estado" required>
                                    @foreach($estados as $estado)
                                    <option value="{{$estado->description}}" {{ $estacion->estado_republica == $estado->description ? 'selected' : '' }}>
                                        {{ $estado->description }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal para generar nueva estación -->
<div class="modal fade" id="generarEstacionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exampleModalLabel">Generar Nueva Estación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="generarEstacionForm" action="{{ route('estaciones.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_estacion">Tipo de servicio</label>
                                <select name="tipo_estacion" id="tipo_estacion" class="form-select" required>
                                    <option value="" disabled selected>Seleccione el tipo de servicio</option>
                                    <option value="Transporte">Transporte</option>
                                    <option value="Estacion de servicio">Estación de servicio</option>
                                    <option value="Almacenamiento">Almacenamiento</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="numestacion">Número de estación</label>
                                <input type="text" name="numestacion" class="form-control" required value="{{ old('numestacion') }}">
                            </div>
                            <div class="form-group">
                                <label for="razonsocial">Razón Social</label>
                                <input type="text" name="razonsocial" class="form-control" required value="{{ old('razonsocial') }}">
                            </div>
                            <div class="form-group">
                                <label for="rfc">RFC</label>
                                <input type="text" name="rfc" class="form-control" required value="{{ old('rfc') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" required value="{{ old('telefono') }}">
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo Electrónico</label>
                                <input type="email" name="correo" class="form-control" required value="{{ old('correo') }}">
                            </div>
                            <div class="form-group">
                                <label for="repre">Representante Legal</label>
                                <input type="text" name="repre" class="form-control" required value="{{ old('repre') }}">
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select name="estado" class="form-select" id="estado" required>
                                    <option value="" selected disabled>Selecciona un estado</option>
                                    @foreach($estados as $estado)
                                    <option value="{{ $estado->description }}">{{ $estado->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center mt-3">
                        <button type="submit" class="btn btn-success">Generar</button>
                    </div>
                </form>
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