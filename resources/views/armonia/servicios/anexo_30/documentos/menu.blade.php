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

<!-- Mostrar detalles del servicio -->
<div class="mb-4 p-3 border rounded bg-light">
    <h5 class="mb-2">Información del Servicio</h5>
    <p class="mb-1"><strong>Nomenclatura:</strong> {{ $servicio->nomenclatura }}</p>
    <p class="mb-1"><strong>Estación:</strong> {{ $servicio->estaciones->first()->razon_social ?? 'Desconocido' }}</p>
    <p class="mb-1"><strong>Estado:</strong> {{ $servicio->estaciones->first()->domicilioServicio->entidad_federativa ?? 'Estado desconocido' }}</p>
    <p class="mb-1"><strong>Municipio:</strong> {{ $servicio->estaciones->first()->domicilioServicio->municipio ?? 'Municipio desconocido' }}</p>
</div>

<div class="row">
    @php
    $documentaciones = [
    ['title' => 'Documentación General', 'action' => route('documentacion.general', ['id' => $servicio->id])],
    ['title' => 'Documentación Informática', 'action' => route('documentacion.informatica', ['id' => $servicio->id])],
    ['title' => 'Documentación de Medición', 'action' => route('documentacion.medicion', ['id' => $servicio->id])],
    ['title' => 'Documentación Inspección', 'action' => route('documentacion.inspeccion', ['id' => $servicio->id])],
    ];
    @endphp

    @foreach($documentaciones as $doc)
    @include('armonia.servicios.anexo_30.documentos.componentes.documento-card', [
    'title' => $doc['title'],
    'action' => $doc['action'],
    'servicio' => $servicio
    ])
    @endforeach
</div>

@endsection