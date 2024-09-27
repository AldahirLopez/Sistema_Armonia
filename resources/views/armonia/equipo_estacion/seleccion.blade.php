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

<!-- Mostrar tablas de Dispensarios y Tanques -->
<div class="row">
    <!-- Tabla de Dispensarios -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Dispensarios</h5>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarDispensario">
                    <i class="bx bx-plus"></i> Agregar Dispensario
                </button>
            </div>
            <div class="card-body p-3">
                @if($dispensarios->isNotEmpty())
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Número de Isla</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Número de Serie</th>
                            @if(auth()->user()->hasRole('Administrador'))
                            <th class="text-center">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dispensarios as $dispensario)
                        <tr>
                            <td>{{ $dispensario->num_isla }}</td>
                            <td>{{ $dispensario->marca }}</td>
                            <td>{{ $dispensario->modelo }}</td>
                            <td>{{ $dispensario->numero_serie }}</td>
                            @if(auth()->user()->hasRole('Administrador'))
                            <td class="text-center">
                                <!-- Botón de Eliminar para Dispensarios -->
                                <form action="{{ route('dispensarios.destroy', ['estacion_id' => $estacion->id, 'id' => $dispensario->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este dispensario?');">
                                        <i class="bx bx-trash"></i>
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
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Tanques</h5>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarTanques">
                    <i class="bx bx-plus"></i> Agregar Tanques
                </button>
            </div>
            <div class="card-body p-3">
                @if($tanques->isNotEmpty())
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Folio</th>
                            <th>Serie</th>
                            <th>Marca</th>
                            <th>Producto</th>
                            <th>Capacidad (L)</th>
                            @if(auth()->user()->hasRole('Administrador'))
                            <th class="text-center">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tanques as $tanque)
                        <tr>
                            <td>{{ $tanque->folio }}</td>
                            <td>{{ $tanque->numero_serie }}</td>
                            <td>{{ $tanque->marca }}</td>
                            <td>{{ $tanque->producto }}</td>
                            <td>{{ $tanque->capacidad }}</td>
                            @if(auth()->user()->hasRole('Administrador'))
                            <td class="text-center">
                                <!-- Botón de Eliminar para Tanques -->
                                <form action="{{ route('tanques.destroy', ['estacion_id' => $estacion->id, 'id' => $tanque->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este tanque?');">
                                        <i class="bx bx-trash"></i>
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

    <div class="row">
        <!-- Tabla de Sondas -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Sondas</h5>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarSondas">
                        <i class="bx bx-plus"></i> Agregar Sonda
                    </button>
                </div>
                <div class="card-body">
                    @if($sondas->isNotEmpty())
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Número de Serie</th>
                                <th>Producto</th>
                                <th>Marca</th>
                                @if(auth()->user()->hasRole('Administrador'))
                                <th>Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sondas as $sonda)
                            <tr>
                                <td>{{ $sonda->folio }}</td>
                                <td>{{ $sonda->numero_serie }}</td>
                                <td>{{ $sonda->producto }}</td>
                                <td>{{ $sonda->marca }}</td>
                                @if(auth()->user()->hasRole('Administrador'))
                                <td class="text-center">
                                    <!-- Botón de Eliminar para Sondas -->
                                    <form action="{{ route('sondas.destroy', ['estacion_id' => $estacion->id, 'id' => $sonda->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta sonda?');">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-center text-muted">No hay sondas registradas.</p>
                    @endif
                </div>
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

<!-- Modal para agregar sondas -->
<div class="modal fade" id="modalAgregarSondas" tabindex="-1" aria-labelledby="modalAgregarSondasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarSondasLabel">Agregar Sonda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sondas.store', $estacion->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="folio" class="form-label">Folio</label>
                        <input type="text" class="form-control" id="folio" name="folio" placeholder="Ingrese el folio" required>
                    </div>
                    <div class="mb-3">
                        <label for="numeroSerie" class="form-label">Número de Serie</label>
                        <input type="text" class="form-control" id="numeroSerie" name="numero_serie" placeholder="Ingrese el número de serie">
                    </div>
                    <div class="mb-3">
                        <label for="producto" class="form-label">Producto</label>
                        <input type="text" class="form-control" id="producto" name="producto" placeholder="Ingrese el producto" required>
                    </div>
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" placeholder="Ingrese la marca" required>
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