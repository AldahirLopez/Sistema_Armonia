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
        <!-- Back Button and Title -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <!-- Back button -->
                        <a href="{{ route('anexo.index') }}" class="btn btn-danger">
                            <i class="bx bx-arrow-back"></i>
                        </a>
                        <!-- Title -->
                        <h3 class="page__heading text-right mb-0">Generar Expediente de {{ $servicioAnexo->nomenclatura }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <!-- Card Column 1 (Left Column) -->
                <div class="col-md-4 mb-4">
                    @include('armonia.servicios.anexo_30.expediente.componentes.expedienteCard', ['service' => $servicioAnexo])
                    
                    <!-- Certificado Card Section -->
                    @if(auth()->check() && auth()->user()->hasRole('Administrador'))
                        @include('armonia.servicios.anexo_30.expediente.componentes.certificadoCard')
                    @endif
                </div>

                <!-- Card Column 2 -->
                <div class="col-md-4 mb-4">
                    @include('armonia.servicios.anexo_30.expediente.componentes.dictamenesCard', [
                        'title' => 'Dictámenes Informáticos',
                        'type' => 'informatico'
                    ])
                    @include('armonia.servicios.anexo_30.expediente.componentes.reporteFotograficoCard', [
                        'title' => 'Reporte Fotográfico',
                        'type' => 'reporte'
                    ])
                </div>

                <!-- Card Column 3 -->
                <div class="col-md-4 mb-4">
                    @include('armonia.servicios.anexo_30.expediente.componentes.dictamenesCard', [
                        'title' => 'Dictámenes de Medición',
                        'type' => 'medicion'
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

    <!-- Modals -->
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
        'direccionFiscal' => $direccionFiscal,
        'direccionEstacion' => $direccionEstacion,
        'estados' => $estados
    ])

    @include('armonia.servicios.anexo_30.expediente.componentes.generarReporteFotografico', [
        'servicioAnexo' => $servicioAnexo,
        'estacion' => $estacion,
        'estados' => $estados
    ])
@endsection

@push('scripts')
    <script src="{{ asset('js/expediente.js') }}"></script>
@endpush
