@extends('layouts.master')

@section('title')
@lang('Documentación del Servicio - Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Servicios @endslot
@slot('title') Documentación del Servicio {{ $servicio->nomenclatura }} @endslot
@endcomponent

<div class="row">
    @php
    $documentaciones = [
    ['title' => 'Documentación General', 'action' => route('documentacion.general')],
    ['title' => 'Documentación Informática', 'action' => route('documentacion.informatica')],
    ['title' => 'Documentación de Medición', 'action' => route('documentacion.medicion')],
    ['title' => 'Documentación Inspección', 'action' => route('documentacion.inspeccion')],
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