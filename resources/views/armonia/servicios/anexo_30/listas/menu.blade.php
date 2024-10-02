@extends('layouts.master')

@section('title')
@lang('Listas del inspección del Servicio - Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Servicios @endslot
@slot('title') Listas del inspección del Servicio {{ $servicio->nomenclatura }} @endslot
@endcomponent

<div class="d-flex justify-content-between mb-4">
    <form action="{{ route('anexo.index') }}" method="GET" style="display:inline;">
        <input type="hidden" name="id" value="{{ $servicio->id }}">
        <button type="submit" class="btn btn-danger">
            <i class="bx bx-arrow-back"></i>
        </button>
    </form>
</div>

<div class="row">
    @php 
    $documentaciones = [
    ['title' => 'Programas informaticos', 'action' => route('listas.seleccion', ['id' => $servicio->id])],
    ['title' => 'Sistemas de medicion', 'action' => route('listas_medicion.seleccion', ['id' => $servicio->id])],
    ];
    @endphp

    @foreach($documentaciones as $doc)
    @include('armonia.servicios.anexo_30.listas.componentes.documento-card', [
    'title' => $doc['title'],
    'action' => $doc['action'],
    'servicio' => $servicio
    ])
    @endforeach
</div>

@endsection