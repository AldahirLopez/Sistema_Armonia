@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Seleccion @endslot
@slot('title') Estaciones de Servicio @endslot
@endcomponent

<h4>Formulario para Estación</h4>

<!-- Formulario principal que envuelve todas las secciones -->
<form action="#" method="POST">
    @csrf

    <!-- Cargar Sección 1 -->
    <div id="seccion01">
        {!! $seccion01 !!}
    </div>

    <!-- Cargar Sección 2 -->
    <div id="seccion02">
        {!! $seccion02 !!}
    </div>

    <!-- Cargar Sección 3 -->
    <div id="seccion03">
        {!! $seccion03 !!}
    </div>

    <!-- Cargar Sección 4 -->
    <div id="seccion04">
        {!! $seccion04 !!}
    </div>

    <!-- Botones de navegación -->
    <div class="form-navigation mt-4">
        <button type="submit" class="btn btn-success">Finalizar</button>
    </div>
</form>

@endsection