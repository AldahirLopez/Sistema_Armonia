@extends('layouts.master')

@section('title')
@lang('Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Selección @endslot
@slot('title') Anexo 30 @endslot
@endcomponent

@include('partials.alertas') <!-- Including alerts -->

<!-- Filtro por Usuario -->
<!-- Filtro por Usuario y Estado de Servicio -->
<div class="row mb-4">
    <div class="col-lg-12">
        <form method="GET" action="{{ route('anexo.index') }}" class="d-flex align-items-center justify-content-center">
            <div class="input-group">
                <!-- Filtro por Usuario -->
                <label for="usuario_id" class="input-group-text border-end-0">Usuario:</label>
                <select name="usuario_id" id="usuario_id" class="form-select border-start-0" style="max-width: 200px;">
                    <option value="">Todos los usuarios</option>
                    @foreach($usuarios as $user)
                    <option value="{{ $user->id }}" {{ $usuarioSeleccionado == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>

                <!-- Filtro por Estado de Servicio -->
                <label for="estado_servicio" class="input-group-text border-end-0 ms-2">Estado:</label>
                <select name="estado_servicio" id="estado_servicio" class="form-select border-start-0" style="max-width: 200px;">
                    <option value="">Todos los estados</option>
                    <option value="aprobado" {{ request('estado_servicio') == 'aprobado' ? 'selected' : '' }}>Aprobados</option>
                    <option value="eliminado" {{ request('estado_servicio') == 'eliminado' ? 'selected' : '' }}>Eliminados</option>
                    <option value="pendiente" {{ request('estado_servicio') == 'pendiente' ? 'selected' : '' }}>Pendientes de Aprobación</option>
                </select>

                <!-- Botón Filtrar -->
                <button class="btn btn-primary ms-2" type="submit">
                    <i class="bx bx-filter-alt"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
</div>



<!-- Buttons for generating new service -->
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <a href="{{ route('documentacion.generarPDF') }}" class="btn btn-primary">
                    <i class="bx bxs-file-pdf"></i> Generar Lista de Requisitos
                </a>
                @if($estaciones->isNotEmpty())
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generarServicioModal">
                    <i class="bx bx-plus-circle"></i> Generar Nuevo Servicio
                </button>
                @else
                <a href="{{ route('estaciones.usuario') }}" class="btn btn-primary">
                    <i class="bx bx-building-house"></i> Registre nuevas estaciones
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Display Services -->
<div class="row">
    @forelse($servicios as $servicio)
    <div class="col-lg-4 col-md-6 mb-4 d-flex">
        <div class="card border-light shadow-sm h-100 w-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title font-weight-bold text-dark text-truncate">
                    {{ $servicio->nomenclatura }}

                    <!-- Edit Button (Only for Admins) -->
                    @if(auth()->user()->hasRole('Administrador'))
                    <button type="button" class="btn btn-outline-primary btn-sm ms-2 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#actualizarNomenclaturaModal-{{ $servicio->id }}" style="border-radius: 20px;">
                        <i class="bx bx-edit me-1"></i> Editar
                    </button>
                    @endif
                </h5>
            </div>

            <div class="card-body d-flex flex-column justify-content-between">
                <!-- Service Status -->
                <p class="text-muted">
                    @if($servicio->pending_apro_servicio && !$servicio->pending_deletion_servicio)
                    <span class="badge bg-success">Aprobado</span>
                    @elseif($servicio->pending_deletion_servicio)
                    <span class="badge bg-danger">Eliminación pendiente de aprobación</span>
                    @else
                    <span class="badge bg-warning text-dark">Pendiente de aprobación</span>
                    @endif
                </p>

                <!-- Service Details -->
                <p class="card-text text-muted mb-3">
                    <strong>Tipo de Servicio:</strong> {{ $servicio->estaciones->first()->tipo_estacion ?? 'Desconocido' }}<br>
                    <strong>Estación:</strong> {{ $servicio->estaciones->first()->razon_social ?? 'Desconocido' }}<br>
                    <strong>Estado:</strong> {{ $servicio->estaciones->first()->domicilioServicio->entidad_federativa ?? 'Estado desconocido' }}<br>
                    <strong>Municipio:</strong> {{ $servicio->estaciones->first()->domicilioServicio->municipio ?? 'Municipio desconocido' }}
                </p>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    @if($servicio->pending_deletion_servicio)
                    <span class="text-muted">Eliminación pendiente de aprobación</span>
                    @else
                    @if($servicio->pending_apro_servicio)
                    <a href="{{ route('armonia.servicios.anexo_30.documentos.menu', ['id' => $servicio->id]) }}" class="btn btn-outline-primary btn-sm" title="Ver Documentación">
                        <i class="bx bx-folder-open"></i> Documentación
                    </a>
                    <a href="{{ route('expediente.index', ['id' => $servicio->id]) }}" class="btn btn-outline-primary btn-sm" title="Ver Expediente">
                        <i class="bx bx-folder-open"></i> Expediente
                    </a>
                    <a href="{{ route('armonia.servicios.anexo_30.listas_inspeccion.menu', ['id' => $servicio->id]) }}" class="btn btn-outline-primary btn-sm" title="Ver Listas de Inspección">
                        <i class="bx bx-folder-open"></i> Listas de Inspección
                    </a>
                    <form action="{{ route('anexo.destroy', $servicio->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar Servicio">
                            <i class="bx bx-trash"></i> Eliminar
                        </button>
                    </form>
                    @else
                    <span class="text-muted">Pendiente de aprobación</span>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-lg-12">
        <div class="alert alert-warning text-center">No se encontraron servicios para mostrar.</div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $servicios->onEachSide(1)->links('pagination::bootstrap-4', ['class' => 'pagination-sm']) }}
</div>

<!-- Modal para generar servicio -->
@include('armonia.servicios.anexo_30.modals.generarServicio', ['estaciones' => $estaciones])

<!-- Modals for Updating Nomenclature -->
@foreach($servicios as $servicio)
<div class="modal fade" id="actualizarNomenclaturaModal-{{ $servicio->id }}" tabindex="-1" aria-labelledby="actualizarNomenclaturaLabel-{{ $servicio->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Nomenclatura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('servicio-anexo.actualizar-nomenclatura', $servicio->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nuevaNomenclatura-{{ $servicio->id }}" class="form-label">Nueva Nomenclatura</label>
                        <input type="text" class="form-control" id="nuevaNomenclatura-{{ $servicio->id }}" name="nueva_nomenclatura" placeholder="Ingrese la nueva nomenclatura" value="{{ $servicio->nomenclatura }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection