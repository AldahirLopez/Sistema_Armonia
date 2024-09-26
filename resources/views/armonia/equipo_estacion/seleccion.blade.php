@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Selección @endslot
@slot('title') Estaciones de Equipo @endslot
@endcomponent
@include('partials.alertas') <!-- Incluyendo las alertas -->

<div class="d-flex justify-content-between align-items-center mb-4">
    <!-- Botón de regreso -->
    <a href="{{ route('estaciones.usuario') }}" class="btn btn-danger">
        <i class="bx bx-arrow-back"></i>
    </a>
    <!-- Título principal -->
    <h3 class="page__heading mb-0">Registrar Estructura de la Gasolinera {{ $estacion->razon_social }}</h3>
</div>

<!-- Sección para añadir Dispensarios y Tanques -->
<div class="row mb-4">
    <div class="col-lg-12 d-flex justify-content-center">
        <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#modalAgregarDispensario">
            <i class="bx bx-plus"></i> Agregar Dispensario
        </button>
        <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#modalAgregarTanques">
            <i class="bx bx-plus"></i> Agregar Tanques
        </button>
    </div>
</div>

<!-- Mostrar tablas de Dispensarios y Tanques -->
<div class="row">
    <!-- Tabla de Dispensarios -->
    <!-- Tabla de Dispensarios -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Dispensarios</h5>
            </div>
            <div class="card-body">
                @if($dispensarios->isNotEmpty())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Número de Isla</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Número de Serie</th>
                            @if(auth()->user()->hasRole('Administrador'))
                            <th>Acciones</th> <!-- Nueva columna para los botones de acción -->
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dispensarios as $dispensario)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dispensario->num_isla }}</td>
                            <td>{{ $dispensario->marca }}</td>
                            <td>{{ $dispensario->modelo }}</td>
                            <td>{{ $dispensario->numero_serie }}</td>
                            @if(auth()->user()->hasRole('Administrador'))
                            <td>
                                <!-- Botón de Editar -->
                                <a href="{{ route('dispensarios.edit', $dispensario->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i> Editar
                                </a>
                                <!-- Botón de Eliminar -->
                                <form action="{{ route('dispensarios.destroy', $dispensario->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este dispensario?');">
                                        <i class="bx bx-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center text-muted">No hay dispensarios registrados.</p>
                @endif
            </div>
        </div>
    </div>


    <!-- Tabla de Tanques -->
    <!-- Tabla de Tanques -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Tanques</h5>
            </div>
            <div class="card-body">
                @if($tanques->isNotEmpty())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Folio</th>
                            <th>Producto</th>
                            <th>Capacidad (L)</th>
                            @if(auth()->user()->hasRole('Administrador'))
                            <th>Acciones</th> <!-- Nueva columna para los botones de acción -->
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tanques as $tanque)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tanque->folio }}</td>
                            <td>{{ $tanque->producto }}</td>
                            <td>{{ $tanque->capacidad }}</td>
                            @if(auth()->user()->hasRole('Administrador'))
                            <td>
                                <!-- Botón de Editar -->
                                <a href="{{ route('tanques.edit', $tanque->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i> Editar
                                </a>
                                <!-- Botón de Eliminar -->
                                <form action="{{ route('tanques.destroy', $tanque->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este tanque?');">
                                        <i class="bx bx-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center text-muted">No hay tanques registrados.</p>
                @endif
            </div>
        </div>
    </div>

</div>

<!-- Modales -->
<!-- Modal para agregar dispensarios -->
<div class="modal fade" id="modalAgregarDispensario" tabindex="-1" aria-labelledby="modalAgregarDispensarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarDispensarioLabel">Agregar Dispensario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dispensarios.store', $estacion->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="numIsla" class="form-label">Número de Isla</label>
                        <input type="text" class="form-control" id="numIsla" name="num_isla" placeholder="Ingrese el número de isla" required>
                    </div>
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" placeholder="Ingrese la marca" required>
                    </div>
                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Ingrese el modelo">
                    </div>
                    <div class="mb-3">
                        <label for="numeroSerie" class="form-label">Número de Serie</label>
                        <input type="text" class="form-control" id="numeroSerie" name="numero_serie" placeholder="Ingrese el número de serie">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para agregar tanques -->
<div class="modal fade" id="modalAgregarTanques" tabindex="-1" aria-labelledby="modalAgregarTanquesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarTanquesLabel">Agregar Tanques</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tanques.store', $estacion->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="folio" class="form-label">Folio</label>
                        <input type="text" class="form-control" id="folio" name="folio" placeholder="Ingrese el folio del tanque" required>
                    </div>
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" placeholder="Ingrese la marca del tanque" required>
                    </div>
                    <div class="mb-3">
                        <label for="producto" class="form-label">Producto</label>
                        <input type="text" class="form-control" id="producto" name="producto" placeholder="Ingrese el producto almacenado" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacidad" class="form-label">Capacidad (L)</label>
                        <input type="number" class="form-control" id="capacidad" name="capacidad" placeholder="Ingrese la capacidad en litros" required min="1">
                    </div>
                    <div class="mb-3">
                        <label for="numeroSerie" class="form-label">Número de Serie</label>
                        <input type="text" class="form-control" id="numeroSerie" name="numero_serie" placeholder="Ingrese el número de serie">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection