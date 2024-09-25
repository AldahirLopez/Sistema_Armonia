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
    <form action="{{ route('servicio_005.index') }}" method="GET" style="display:inline;">
        <input type="hidden" name="id" value="{{ $servicio->id }}">
        <button type="submit" class="btn btn-danger">
            <i class="bx bx-arrow-back"></i>
        </button>
    </form>
</div>

<div class="row">
    @php 
    $documentaciones = [
    ['title' => 'Documentación General', 'action' => route('documentacion_servicio_005.general', ['id' => $servicio->id])],
    ['title' => 'Documentos Expedidos por Terceros', 'action' => route('documentacion_servicio_005.terceros', ['id' => $servicio->id])],
    ];
    @endphp

    @foreach($documentaciones as $doc)
    @include('armonia.servicios.005.documentos.componentes.documento-card', [
    'title' => $doc['title'],
    'action' => $doc['action'],
    'servicio' => $servicio
    ])
    @endforeach
</div>

@endsection