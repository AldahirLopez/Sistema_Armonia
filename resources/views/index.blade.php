@extends('layouts.master')

@section('title')
@lang('translation.Dashboard')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Inicio @endslot
@slot('title') Principal @endslot
@endcomponent

<div class="row">
    <!-- Sección de eventos -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm border-0 h-100" style="min-height: 350px;">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Eventos del Mes</h5>
            </div>
            <div class="card-body p-3" style="max-height: 350px; overflow-y: auto;">
                @if($eventos->isEmpty())
                <p class="text-muted text-center">No hay eventos programados para este mes.</p>
                @else
                <ul class="list-group list-group-flush">
                    @foreach($eventos as $evento)
                    <li class="list-group-item p-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div style="flex-grow: 1;">
                                <h6 class="mb-1" style="font-size: 15px;">{{ $evento->title }}</h6>
                                <small class="text-muted">
                                    <strong>{{ \Carbon\Carbon::parse($evento->start_date)->format('d M') }} -
                                        {{ \Carbon\Carbon::parse($evento->end_date)->format('d M') }}</strong> |
                                    {{ $evento->duration_days }} día(s)
                                </small>
                            </div>
                            <div>
                                <span class="badge bg-light text-dark">
                                    {{ \Carbon\Carbon::parse($evento->start_time)->format('H:i') }}
                                </span>
                            </div>
                        </div>
                        @switch($evento->category)
                        @case('bg-success')
                        <small class="text-success mt-1">Inicio de Ruta</small>
                        @break
                        @case('bg-info')
                        <small class="text-info mt-1">Reunión Virtual</small>
                        @break
                        @case('bg-warning')
                        <small class="text-warning mt-1">Generando Informes</small>
                        @break
                        @case('bg-danger')
                        <small class="text-danger mt-1">Evaluación de Vigilancia</small>
                        @break
                        @case('bg-dark')
                        <small class="text-dark mt-1">Otro</small>
                        @break
                        @default
                        <small class="text-muted mt-1">Sin categoría definida</small>
                        @endswitch
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>

    <!-- Gráfico de barras horizontal de servicios por inspector -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm border-0 h-100" style="min-height: 350px;">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Servicios Creados por Inspector</h5>
            </div>
            <div class="card-body">
                <div id="horizontal_bar_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- ApexCharts -->
<script src="{{ asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

@php
$serviciosData = $serviciosPorInspector->pluck('total_servicios')->toArray();
$inspectoresData = $serviciosPorInspector->pluck('usuario.name')->toArray();
@endphp

<script>
    // Pasar los datos de PHP a JavaScript
    var serviciosData = @json($serviciosData);
    var inspectoresData = @json($inspectoresData);
</script>

<!-- Incluir el archivo JS -->
<script src="{{ asset('build/js/home.js') }}"></script>
@endsection