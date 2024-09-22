@extends('layouts.master')

@section('title')
@lang('translation.Dashboard')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Inicio @endslot
@slot('title') Principal @endslot
@endcomponent

<!-- Sección para mostrar los eventos del mes en curso en una tarjeta más compacta -->
<div class="row">
    <div class="col-lg-6"> <!-- Cambiado a col-lg-6 para permitir espacio a más tarjetas al lado -->
        <div class="card shadow-sm" style="height: 100%;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Eventos del Mes</h5>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;"> <!-- Limitar la altura con scroll -->
                @if($eventos->isEmpty())
                <p class="text-muted text-center">No hay eventos programados para este mes.</p>
                @else
                <ul class="list-group list-group-flush">
                    @foreach($eventos as $evento)
                    <li class="list-group-item p-1"> <!-- Reducir el padding -->
                        <div class="d-flex justify-content-between align-items-start">
                            <div style="flex-grow: 1;">
                                <h6 class="mb-0 font-weight-bold" style="font-size: 14px;">{{ $evento->title }}</h6>
                                <small class="text-muted">
                                    <!-- Mostrar las fechas de inicio y fin usando la variable duration_days -->
                                    <strong>{{ \Carbon\Carbon::parse($evento->start_date)->format('d M') }} -
                                        {{ \Carbon\Carbon::parse($evento->end_date)->format('d M') }}</strong> |
                                    {{ $evento->duration_days }} día(s)
                                </small>
                            </div>
                            <div>
                                <span class="badge bg-light text-dark">
                                    Hora de Inicio: {{ \Carbon\Carbon::parse($evento->start_time)->format('H:i') }}
                                </span>
                            </div>
                        </div>

                        <!-- Categoría compacta -->
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

    <!-- Aquí puedes agregar otra tarjeta en la misma fila -->
    <div class="col-lg-6">
        <!-- Aquí puedes poner otra tarjeta o contenido adicional -->
    </div>
</div>
@endsection