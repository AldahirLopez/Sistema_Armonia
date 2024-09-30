@extends('layouts.master')

@section('title')
@lang('Rutas de Inspectores')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Rutas @endslot
@slot('title') Listado de Rutas de Inspectores @endslot
@endcomponent

<div class="container">
    <h1>Rutas de Inspectores</h1>

    @foreach ($rutasPorInspector as $inspector => $rutas)
    <h2>Inspector: {{ $inspector }}</h2>

    <!-- Tabla para Anexo 30 -->
    <h3>Servicios Anexo 30</h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Estación</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Finalización</th>
                <th>Tipo de Servicio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rutas->filter(fn($ruta) => str_contains($ruta['title'], 'Anexo 30')) as $ruta)
            <tr>
                <td>{{ $ruta['estacion'] }}</td>
                <td>{{ \Carbon\Carbon::parse($ruta['start'])->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($ruta['end'])->format('d/m/Y') }}</td>
                <td>{{ $ruta['title'] }}</td>
                <td>{{ $ruta['estado'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No hay rutas de Anexo 30 registradas</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tabla para 005 -->
    <h3>Servicios 005</h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Estación</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Finalización</th>
                <th>Tipo de Servicio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rutas->filter(fn($ruta) => str_contains($ruta['title'], '005')) as $ruta)
            <tr>
                <td>{{ $ruta['estacion'] }}</td>
                <td>{{ \Carbon\Carbon::parse($ruta['start'])->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($ruta['end'])->format('d/m/Y') }}</td>
                <td>{{ $ruta['title'] }}</td>
                <td>{{ $ruta['estado'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No hay rutas de 005 registradas</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @endforeach
</div>
@endsection