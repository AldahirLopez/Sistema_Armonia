@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Selección @endslot
@slot('title') Estaciones de Equipo @endslot
@endcomponent

<div class="d-flex justify-content-between align-items-center mb-4">
    <!-- Botón de regreso -->
    <a href="{{ route('estaciones.usuario') }}" class="btn btn-danger">
        <i class="bx bx-arrow-back"></i>
    </a>
    <!-- Título principal -->
    <h3 class="page__heading mb-0">Registrar Estructura de la Gasolinera {{ $estacion->razon_social }}</h3>
</div>

<div class="row">
    <!-- Tabla: Islas -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Islas</h5>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarIsla">
                    <i class="bx bx-plus"></i> Agregar Isla
                </button>
            </div>
            <div class="card-body">
                <!-- Tabla de Islas -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Número de Isla</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($islas as $isla)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $isla->numero_isla }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabla: Dispensarios -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Dispensarios</h5>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarDispensario">
                    <i class="bx bx-plus"></i> Agregar Dispensario
                </button>
            </div>
            <div class="card-body">
                <!-- Tabla de Dispensarios -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Número de Dispensario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dispensarios as $dispensario)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dispensario->numero_dispensario }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabla: Tanques -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Tanques</h5>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarTanque">
                    <i class="bx bx-plus"></i> Agregar Tanque
                </button>
            </div>
            <div class="card-body">
                <!-- Tabla de Tanques -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Capacidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tanques as $tanque)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tanque->producto }}</td>
                            <td>{{ $tanque->capacidad }} L</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabla: Sondas -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Sondas</h5>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarSonda">
                    <i class="bx bx-plus"></i> Agregar Sonda
                </button>
            </div>
            <div class="card-body">
                <!-- Tabla de Sondas -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Número de Serie</th>
                            <th>Producto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sondas as $sonda)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sonda->numero_serie }}</td>
                            <td>{{ $sonda->producto }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modales 
@include('armonia.servicios.islas.modalAgregarIsla')
@include('armonia.servicios.dispensarios.modalAgregarDispensario')
@include('armonia.servicios.tanques.modalAgregarTanque')
@include('armonia.servicios.sondas.modalAgregarSonda')
-->
@endsection