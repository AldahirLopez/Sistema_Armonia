@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Selección @endslot
@slot('title') Estaciones de Equipo @endslot
@endcomponent
@include('partials.alertas')

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('estaciones.usuario') }}" class="btn btn-danger">
        <i class="bx bx-arrow-back"></i>
    </a>
    <h3 class="page__heading mb-0">Registrar Estructura de la Gasolinera {{ $estacion->razon_social }}</h3>
</div>

<div class="row">
    @include('armonia.Equipo_estacion.partials.dispensarios')
    @include('armonia.Equipo_estacion.partials.tanques')
</div>

<div class="row">
    @include('armonia.Equipo_estacion.partials.sondas')
    @include('armonia.Equipo_estacion.partials.veeder-root')
</div>

<div class="row">
    @include('armonia.Equipo_estacion.partials.medidor_flujo')
</div>

<!-- Modales -->
@component('armonia.equipo_estacion.components.modal', ['modalId' => 'Dispensario', 'modalTitle' => 'Dispensario', 'storeRoute' => 'dispensarios.store', 'estacion' => $estacion])
<!-- Contenido del modal para Dispensarios -->
<div class="mb-3">
    <label for="numIsla" class="form-label">Número de Isla</label>
    <input type="text" class="form-control" id="numIsla" name="num_isla" placeholder="Ingrese el número de isla" required>
</div>
<div class="mb-3">
    <label for="marca" class="form-label">Marca</label>
    <input type="text" class="form-control" id="marca" name="marca" placeholder="Ingrese la marca" required>
</div>
<div class="mb-3">
    <label for="modelo" class="form-label">Modelo</label>
    <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Ingrese el modelo">
</div>
<div class="mb-3">
    <label for="numeroSerie" class="form-label">Número de Serie</label>
    <input type="text" class="form-control" id="numeroSerie" name="numero_serie" placeholder="Ingrese el número de serie">
</div>
<div class="mb-3">
    <label for="numeroAprobacion" class="form-label">Número de Aprobación</label>
    <input type="text" class="form-control" id="numeroAprobacion" name="numero_aprobacion" placeholder="Ingrese el número de aprobación DNG">
</div>
@endcomponent

@component('armonia.equipo_estacion.components.modal', ['modalId' => 'Tanques', 'modalTitle' => 'Tanques', 'storeRoute' => 'tanques.store', 'estacion' => $estacion])
<!-- Contenido del modal para Tanques -->
<div class="mb-3">
    <label for="folio" class="form-label">Folio</label>
    <input type="text" class="form-control" id="folio" name="folio" placeholder="Ingrese el folio del tanque" required>
</div>
<div class="mb-3">
    <label for="marca" class="form-label">Marca</label>
    <input type="text" class="form-control" id="marca" name="marca" placeholder="Ingrese la marca del tanque" required>
</div>
<div class="mb-3">
    <label for="producto" class="form-label">Producto</label>
    <input type="text" class="form-control" id="producto" name="producto" placeholder="Ingrese el producto almacenado" required>
</div>
<div class="mb-3">
    <label for="capacidad" class="form-label">Capacidad (L)</label>
    <input type="number" class="form-control" id="capacidad" name="capacidad" placeholder="Ingrese la capacidad en litros" required min="1">
</div>
<div class="mb-3">
    <label for="numeroSerie" class="form-label">Número de Serie</label>
    <input type="text" class="form-control" id="numeroSerie" name="numero_serie" placeholder="Ingrese el número de serie del tanque">
</div>
@endcomponent

@component('armonia.equipo_estacion.components.modal', ['modalId' => 'Sondas', 'modalTitle' => 'Sondas', 'storeRoute' => 'sondas.store', 'estacion' => $estacion])
<!-- Contenido del modal para Sondas -->
<div class="mb-3">
    <label for="folio" class="form-label">Folio</label>
    <input type="text" class="form-control" id="folio" name="folio" placeholder="Ingrese el folio" required>
</div>
<div class="mb-3">
    <label for="numeroSerie" class="form-label">Número de Serie</label>
    <input type="text" class="form-control" id="numeroSerie" name="numero_serie" placeholder="Ingrese el número de serie">
</div>
<div class="mb-3">
    <label for="producto" class="form-label">Producto</label>
    <input type="text" class="form-control" id="producto" name="producto" placeholder="Ingrese el producto" required>
</div>
<div class="mb-3">
    <label for="marca" class="form-label">Marca</label>
    <input type="text" class="form-control" id="marca" name="marca" placeholder="Ingrese la marca" required>
</div>
@endcomponent

@component('armonia.equipo_estacion.components.modal', ['modalId' => 'VeederRoot', 'modalTitle' => 'Veeder-Root', 'storeRoute' => 'veeder-root.store', 'estacion' => $estacion])
<!-- Contenido del modal para Veeder-Root -->
<div class="mb-3">
    <label for="marca" class="form-label">Marca</label>
    <input type="text" class="form-control" id="marca" name="marca" placeholder="Ingrese la marca" required>
</div>
<div class="mb-3">
    <label for="modelo" class="form-label">Modelo</label>
    <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Ingrese el modelo" required>
</div>
<div class="mb-3">
    <label for="numeroSerie" class="form-label">Número de Serie</label>
    <input type="text" class="form-control" id="numeroSerie" name="numero_serie" placeholder="Ingrese el número de serie" required>
</div>
@endcomponent

@component('armonia.equipo_estacion.components.modal', ['modalId' => 'MedidorFlujo','modalTitle' => 'Medidor de Flujo','storeRoute' => 'medidor-flujo.store','estacion' => $estacion
])
<!-- Contenido del modal para Medidor de Flujo -->
<div class="mb-3">
    <label for="dispensario_id" class="form-label">Seleccionar Dispensario</label>
    <select name="dispensario_id" id="dispensario_id" class="form-select" required>
        <option value="">Seleccione un dispensario</option>
        @foreach($dispensarios as $dispensario)
        <option value="{{ $dispensario->id }}">Isla: {{ $dispensario->num_isla }} - Marca: {{ $dispensario->marca }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="marca" class="form-label">Marca</label>
    <input type="text" class="form-control" id="marca" name="marca" placeholder="Ingrese la marca" required>
</div>
<div class="mb-3">
    <label for="numeroSerie" class="form-label">Número de Serie</label>
    <input type="text" class="form-control" id="numeroSerie" name="numero_serie" placeholder="Ingrese el número de serie">
</div>
@endcomponent


@endsection