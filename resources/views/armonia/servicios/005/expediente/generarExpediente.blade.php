@extends('layouts.master')

@section('title')
@lang('Servicio 005')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Selección @endslot
@slot('title') Servicio 005 @endslot
@endcomponent

<section class="section">
    <!-- Botón para volver y generar nuevo expediente -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <!-- Botón de regresar a la izquierda -->
                    <a href="{{ route('servicio_005.index') }}" class="btn btn-danger">
                        <i class="bx bx-arrow-back"></i>
                    </a>
                    <!-- Título a la derecha -->
                    <h3 class="page__heading text-right mb-0">Generar Expediente de {{ $servicio->nomenclatura }}</h3>
                </div>
            </div>
        </div>
    </div>


    <div class="section-body">
        <div class="row">
            <!-- Expediente Section -->
            <div class="col-md-4 mb-4">
                @include('armonia.servicios.005.expediente.componentes.expedienteCard', ['service' => $servicio])
            </div>

            <div class="col-md-4 mb-4">
                @include('armonia.servicios.005.expediente.componentes.reporteFotograficoCard', [
                'title' => 'REPORTE FOTOGRAFICO',
                'type' => 'reporte'
                ])
            </div>
 
        </div>

        <!-- Generated Files Table -->
        <div class="row mt-4">
            <div class="col-lg-12">
                @include('armonia.servicios.anexo_30.expediente.componentes.generatedFilesTable', [
                'existingFiles' => $existingFiles
                ])
            </div>
        </div>
    </div>
</section>

<!-- Modales -->
@include('armonia.servicios.005.expediente.componentes.generarExpediente', [
'servicio_005' => $servicio,
'estacion' => $estacion,
'estados' => $estados
])

@include('armonia.servicios.005.expediente.componentes.generarReporteFotografico', [
'servicio_005' => $servicio,
'estacion' => $estacion,
'estados' => $estados
])

@endsection

@push('scripts')
<script src="{{ asset('js/expediente.js') }}"></script>
@endpush