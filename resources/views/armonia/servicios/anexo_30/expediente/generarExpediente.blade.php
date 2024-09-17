@extends('layouts.master')

@section('title')
@lang('Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Selección @endslot
@slot('title') Anexo 30 @endslot
@endcomponent

<section class="section">
    <!-- Botón para volver y generar nuevo expediente -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <!-- Botón de regresar a la izquierda -->
                    <a href="{{ route('anexo.index') }}" class="btn btn-danger">
                        <i class="bx bx-arrow-back"></i>
                    </a>
                    <!-- Título a la derecha -->
                    <h3 class="page__heading text-right mb-0">Generar Expediente de {{ $servicioAnexo->nomenclatura }}</h3>
                </div>
            </div>
        </div>
    </div>


    <div class="section-body">
        <div class="row">
            <!-- Expediente Section -->
            <div class="col-md-4 mb-4">
                @include('armonia.servicios.anexo_30.expediente.componentes.expedienteCard', ['service' => $servicioAnexo])
            </div>

            <div class="col-md-4 mb-4">
                @include('armonia.servicios.anexo_30.expediente.componentes.dictamenesCard', [
                'title' => 'Dictámenes Informáticos',
                'type' => 'informatico'
                ])
            </div>

            <div class="col-md-4 mb-4">
                @include('armonia.servicios.anexo_30.expediente.componentes.dictamenesCard', [
                'title' => 'Dictámenes de Medición',
                'type' => 'medicion'
                ])
            </div>

            @if(auth()->check() && auth()->user()->hasRole('Administrador'))
            <div class="col-md-4 mb-4">
                @include('armonia.servicios.anexo_30.expediente.componentes.certificadoCard')
            </div>
            @endif
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
@include('armonia.servicios.anexo_30.expediente.componentes.generarExpediente', [
'servicioAnexo' => $servicioAnexo,
'estacion' => $estacion,
'estados' => $estados
])

@include('armonia.servicios.anexo_30.expediente.partials.generarDictamenInformaticosForm', [
'title' => 'Dictámenes Informáticos',
'type' => 'informatico',
'servicioAnexo' => $servicioAnexo,
'estacion' => $estacion
])

@include('armonia.servicios.anexo_30.expediente.partials.generarDictamenMedicionForm', [
'title' => 'Dictámenes de Medición',
'servicioAnexo' => $servicioAnexo,
'estacion' => $estacion
])

@include('armonia.servicios.anexo_30.expediente.partials.generarCertificadoForm', [
'title' => 'Certificado JSON',
'servicioAnexo' => $servicioAnexo,
'estacion' => $estacion,
'direccionFiscal' => $direccionFiscal, // Asegúrate de pasar estas variables si son necesarias
'direccionEstacion' => $direccionEstacion,
'estados' => $estados
])


@endsection

@push('scripts')
<script src="{{ asset('js/expediente.js') }}"></script>
@endpush