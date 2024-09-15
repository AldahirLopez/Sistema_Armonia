@extends('layouts.master')

@section('title')
@lang('Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Selección @endslot
@slot('title') Anexo 30 @endslot
@endcomponent

@include('partials.alertas') <!-- Incluyendo las alertas -->

<!-- Botón para volver y generar nuevo servicio -->
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <a href="#" class="btn btn-danger">
                    <i class="bx bx-arrow-back"></i>
                </a>

                <a href="{{ route('documentacion.generarPDF') }}" class="btn btn-primary mx-auto">
                    <i class="bx bxs-file-pdf"></i> Generar Lista Completa PDF
                </a>

                @if($estaciones->isNotEmpty())
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generarServicioModal">
                    <i class="bx bx-plus-circle"></i> Generar Nuevo Servicio
                </button>
                @else
                <a href="#" class="btn btn-primary">
                    <i class="bx bx-building-house"></i> Registre su primera estación
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
                    @if($servicio->pending_apro_servicio)
                    <span class="badge bg-success">Aprobado</span>
                    @else
                    <span class="badge bg-warning text-dark">Pendiente de aprobación</span>
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
                    @if($servicio->pending_apro_servicio)
                    <!-- Botones de acción con íconos y estilo más sutil -->
                    <a href="{{ route('armonia.servicios.anexo_30.documentos.menu', ['id' => $servicio->id]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-folder-open"></i> Documentación
                    </a>
                    <form action="{{ route('anexo.destroy', $servicio->id) }}" method="POST" style="display:inline;">
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
@include('armonia.servicios.anexo_30.modals.generarServicio', ['estaciones' => $estaciones])

@endsection