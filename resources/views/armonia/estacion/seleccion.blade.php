@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Seleccion @endslot
@slot('title') Estaciones de Servicio @endslot
@endcomponent

<div class="row">
    <!-- Tarjeta: Estaciones de Servicio para Administradores -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="margin-top: 20px;">Estaciones de Servicio</h5>
                <div class="d-flex justify-content-between">
                    <div class="text-primary">
                        <h2><i class="bx bx-cog"></i><i class="bx bx-gas-pump"></i></h2>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <h4><span></span></h4>
                        <p class="mb-0">
                            <a href="{{ route('estaciones.usuario') }}" class="text-primary">Ver más...</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta: Estaciones de Servicio Disponibles -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="margin-top: 20px;">Estaciones de Servicio Disponibles</h5>
                <div class="d-flex justify-content-between">
                    <div class="text-primary">
                        <h2><i class="bx bx-check-circle"></i><i class="bx bx-gas-pump"></i></h2>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <h4><span></span></h4>
                        <p class="mb-0">
                            <a href="{{ route('estaciones.disponibles') }}" class="text-primary">Ver más...</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection