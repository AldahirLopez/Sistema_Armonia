@extends('layouts.master')

@section('title')
@lang('Documentación del Servicio - Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Servicios @endslot
@slot('title') Documentación del Servicio {{ $servicio->nomenclatura }} @endslot
@endcomponent

<div class="d-flex justify-content-between mb-4">
    <form action="{{ route('anexo.index') }}" method="GET" style="display:inline;">
        <input type="hidden" name="id" value="{{ $servicio->id }}">
        <button type="submit" class="btn btn-danger">
            <i class="bx bx-arrow-back"></i>
        </button>
    </form>
</div>

<!-- Información del Servicio en Dos Columnas -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-3">Información del Servicio</h5>
        <div class="row">
            <!-- Columna 1: Datos del Servicio -->
            <div class="col-md-6">
            <div class="d-flex align-items-center mb-2">
                    <i class="bx bx-building-house me-2"></i>
                    <strong>Tipo de Servicio:</strong>
                    <span class="ms-1 text-muted">{{ $servicio->estaciones->first()->tipo_estacion ?? 'Desconocido' }}</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="bx bx-id-card me-2"></i>
                    <strong>Nomenclatura:</strong>
                    <span class="ms-1 text-muted">{{ $servicio->nomenclatura }}</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="bx bx-building-house me-2"></i>
                    <strong>Estación:</strong>
                    <span class="ms-1 text-muted">{{ $servicio->estaciones->first()->razon_social ?? 'Desconocido' }}</span>
                </div>
                
            </div>

            <!-- Columna 2: Dirección -->
            <div class="col-md-6">
                @php
                $direccion = $servicio->estaciones->first()->domicilioServicio ?? null;
                @endphp

                @if($direccion)
                <div class="row g-1"> <!-- Reducir espacio entre columnas con 'g-1' -->
                    <!-- Sub-Columna 1 de la Dirección -->
                    <div class="col-6">
                        <div class="d-flex align-items-center mb-1">
                            <i class="bx bx-street-view me-2"></i>
                            <strong>Calle:</strong>
                            <span class="ms-1 text-muted">{{ $direccion->calle ?? 'No especificado' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <i class="bx bx-map me-2"></i>
                            <strong>Núm. Ext:</strong>
                            <span class="ms-1 text-muted">{{ $direccion->numero_exterior ?? 'S/N' }}</span>
                        </div>
                        @if($direccion->numero_interior)
                        <div class="d-flex align-items-center mb-1">
                            <i class="bx bx-door-open me-2"></i>
                            <strong>Núm. Int:</strong>
                            <span class="ms-1 text-muted">{{ $direccion->numero_interior }}</span>
                        </div>
                        @endif
                        <div class="d-flex align-items-center mb-1">
                            <i class="bx bx-map-pin me-2"></i>
                            <strong>Colonia:</strong>
                            <span class="ms-1 text-muted">{{ $direccion->colonia ?? 'No especificado' }}</span>
                        </div>
                    </div>

                    <!-- Sub-Columna 2 de la Dirección -->
                    <div class="col-6">
                        <div class="d-flex align-items-center mb-1">
                            <i class="bx bx-mail-send me-2"></i>
                            <strong>C.P.:</strong>
                            <span class="ms-1 text-muted">{{ $direccion->codigo_postal ?? 'No especificado' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <i class="bx bx-city me-2"></i>
                            <strong>Municipio:</strong>
                            <span class="ms-1 text-muted">{{ $direccion->municipio ?? 'No especificado' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <i class="bx bx-globe me-2"></i>
                            <strong>Estado:</strong>
                            <span class="ms-1 text-muted">{{ $direccion->entidad_federativa ?? 'No especificado' }}</span>
                        </div>
                        @if($direccion->entre_calles)
                        <div class="d-flex align-items-center mb-1">
                            <i class="bx bx-directions me-2"></i>
                            <strong>Entre Calles:</strong>
                            <span class="ms-1 text-muted">{{ $direccion->entre_calles }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <p class="text-muted"><i class="bx bx-error"></i> Dirección no especificada</p>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="row">
    @php
    $documentaciones = [
    ['title' => 'Documentación General', 'action' => route('documentacion.general', ['id' => $servicio->id]), 'categoria' => 'generales'],
    ['title' => 'Documentación Informática', 'action' => route('documentacion.informatica', ['id' => $servicio->id]), 'categoria' => 'informatica'],
    ['title' => 'Documentación de Medición', 'action' => route('documentacion.medicion', ['id' => $servicio->id]), 'categoria' => 'medicion'],
    ['title' => 'Documentación Inspección', 'action' => route('documentacion.inspeccion', ['id' => $servicio->id]), 'categoria' => 'inspeccion'],
    ];
    @endphp

    @foreach($documentaciones as $doc)
    @php
    $categoria = $doc['categoria'];
    $isComplete = $categoriasInfo[$categoria]['isComplete'] ?? false;
    $totalDocumentos = $categoriasInfo[$categoria]['total'] ?? 0;
    $documentosSubidos = $categoriasInfo[$categoria]['subidos'] ?? 0;
    @endphp

    @include('armonia.servicios.anexo_30.documentos.componentes.documento-card', [
    'title' => $doc['title'],
    'action' => $doc['action'],
    'servicio' => $servicio,
    'isComplete' => $isComplete,
    'documentosSubidos' => $documentosSubidos,
    'totalDocumentos' => $totalDocumentos
    ])
    @endforeach
</div>



@endsection