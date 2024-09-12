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

<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <a href="#" class="btn btn-danger">
                    <i class="bx bx-arrow-back"></i> Volver
                </a>
                @if($estaciones->isNotEmpty())
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generarServicioModal">
                    Generar Nuevo Servicio
                </button>
                @else
                <a href="#" class="btn btn-primary">Registre su primera estación</a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Mostrar servicios -->
<div class="row">
    @forelse($servicios as $servicio)
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $servicio->nomenclatura }}</h5>

                <div class="d-flex justify-content-between">
                    @can('Descargar-factura-anexo_30')
                    @if ($servicio->pago && $servicio->pago->estado_pago)
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="bi bi-file-earmark-check-fill"></i> Factura
                    </a>
                    @else
                    <span class="text-muted">
                        {{ $servicio->pago ? 'Generando factura' : 'Subir pago para generar factura' }}
                    </span>
                    @endif
                    @endcan

                    <!-- Botón desplegable para acciones adicionales -->
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="accionesServicio{{ $servicio->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            Acciones
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="accionesServicio{{ $servicio->id }}">
                            @if($servicio->pending_apro_servicio)
                            <!-- Si el servicio está aprobado, muestra las opciones -->
                            <li>
                                <form action="#" method="GET">
                                    <input type="hidden" name="id" value="{{ $servicio->id }}">
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-folder-fill"></i> Documentación
                                    </button>
                                </form>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    <i class="bi bi-folder-fill"></i> Expediente
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('anexo.destroy', $servicio->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-trash-fill"></i> Eliminar
                                    </button>
                                </form>
                            </li>
                            @else
                            <!-- Si el servicio no está aprobado, muestra el mensaje -->
                            <li class="dropdown-item text-muted">
                                Servicio pendiente de aprobación
                            </li>
                            @endif
                        </ul>
                    </div>

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
<div class="d-flex justify-content-center">
    {{ $servicios->links() }} <!-- Aquí mostramos la paginación -->
</div>


<!-- Modal para generar servicio -->
@include('armonia.servicios.anexo_30.modals.generarServicio', ['estaciones' => $estaciones])

@endsection