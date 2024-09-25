@extends('layouts.master')

@section('title')
@lang('005')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Selección @endslot
@slot('title') Servicio 005 @endslot
@endcomponent

@include('partials.alertas') <!-- Incluyendo las alertas -->

<!-- Botón para volver y generar nuevo servicio -->
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between">
                <a href="{{ route('documentacion_servicio_005.generarPDF') }}" class="btn btn-primary">
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


<!-- Mostrar servicios -->
<div class="row">
    @forelse($servicios as $servicio)
    <div class="col-lg-4 col-md-6 mb-4 d-flex">
        <div class="card border-light shadow-sm h-100 w-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title font-weight-bold text-dark text-truncate">{{ $servicio->nomenclatura }}</h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
                <!-- Estado del servicio -->
                <p class="text-muted">
                    @if($servicio->pending_apro_servicio && $servicio->pending_deletion_servicio==false )
                    <span class="badge bg-success">Aprobado</span>
                    @else
                    @if($servicio->pending_deletion_servicio)
                    <span class="badge bg-warning text-dark"></span>
                    @else
                    <span class="badge bg-warning text-dark">Pendiente de aprobación</span>
                    @endif
                    @endif

                    @if($servicio->pending_deletion_servicio)
                    <span class="badge bg-danger">Eliminación pendiente de aprobación</span>
                    @endif
                </p>

                <!-- Mostrar las estaciones relacionadas con el servicio -->
                <p class="card-text text-muted mb-3">
                    Servicio para la estación:
                    @if($servicio->estaciones->isNotEmpty())
                    @foreach($servicio->estaciones as $estacion)
                    {{ $estacion->razon_social }}@if(!$loop->last), @endif
                    @endforeach
                    @else
                    Desconocido
                    @endif
                </p>

                <div class="d-flex justify-content-between align-items-center mt-auto">
                    @if($servicio->pending_deletion_servicio)
                    <!-- Si el servicio tiene pendiente la eliminación, desactivar botones -->
                    <span class="text-muted">Eliminación pendiente de aprobación</span>
                    @else
                    @if($servicio->pending_apro_servicio)
                    <!-- Botones de acción con íconos y estilo más sutil -->
                    <a href="{{ route('armonia.servicios.005.documentos.menu', ['id' => $servicio->id]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-folder-open"></i> Documentación
                    </a>

                    <a href="{{ route('expediente_servicio_005.index', ['id' => $servicio->id]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-folder-open"></i> Expediente
                    </a>

                    <a href="{{ route('listas.seleccion', ['id' => $servicio->id]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-folder-open"></i> Listas de Inspeccion
                    </a>

                    <form action="{{ route('servicio_005.destroy', $servicio->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bx bx-trash"></i> Eliminar
                        </button>
                    </form>
                    @else
                    <!-- Si el servicio no está aprobado, solo muestra el mensaje -->
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


<!-- Paginación -->
<div class="d-flex justify-content-center mt-4">
    {{ $servicios->links() }} <!-- Paginación centrada -->
</div>

<!-- Modal para generar servicio -->
@include('armonia.servicios.005.modals.generarServicio005', ['estaciones' => $estaciones])

@endsection