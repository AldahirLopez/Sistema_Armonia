@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Direcciones @endslot
@slot('title') Direciones: {{ $estacion->num_estacion }} - {{ $estacion->razon_social }} @endslot
@endcomponent

@include('partials.alertas') <!-- Incluyendo las alertas -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('estaciones.usuario') }}" class="btn btn-danger">
                        <i class="bx bx-arrow-back"></i>
                    </a>
                </div>

                <!-- Contenedor de las tablas de direcciones -->
                <div class="container mt-4">
                    <!-- Incluir la tabla de Dirección Fiscal -->
                    @include('armonia.direcciones.partials._direccion_fiscal')

                    <!-- Incluir la tabla de Dirección de Estación -->
                    @include('armonia.direcciones.partials._direccion_estacion')


                </div>
                <!-- Incluir los modales para editar direcciones -->
                @include('armonia.direcciones.partials._modal_direccion_fiscal_edit')
                @include('armonia.direcciones.partials._modal_direccion_estacion_edit')

                <!-- Incluir los modales -->
                @include('armonia.direcciones.partials._modal_direccion_fiscal')
                @include('armonia.direcciones.partials._modal_direccion_estacion')
            </div>
        </div>
    </div>
</div>
@endsection