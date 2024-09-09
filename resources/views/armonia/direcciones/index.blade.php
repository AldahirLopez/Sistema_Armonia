@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Seleccion @endslot
@slot('title') Estaciones de Servicio @endslot
@endcomponent
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>¡Éxito!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>¡Error!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Advertencia:</strong> {{ session('warning') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong>Información:</strong> {{ session('info') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('estaciones.usuario') }}" class="btn btn-danger">
                        <i class="bx bx-arrow-back"></i> Regresar
                    </a>
                </div>

                <!-- Contenedor de las tablas de direcciones -->
                <div class="container mt-4">
                    <!-- Incluir la tabla de Dirección Fiscal -->
                    @include('armonia.direcciones.partials._direccion_fiscal')

                    <!-- Incluir la tabla de Dirección de Estación -->
                    @include('armonia.direcciones.partials._direccion_estacion')
                </div>

                <!-- Incluir los modales -->
                @include('armonia.direcciones.partials._modal_direccion_fiscal')
                @include('armonia.direcciones.partials._modal_direccion_estacion')
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selección de estado y municipios para la creación y edición
        const estadoSelect = document.getElementById('entidad_federativa_fiscal');
        const municipioSelect = document.getElementById('municipio_id_fiscal');

        if (estadoSelect && municipioSelect) {
            estadoSelect.addEventListener('change', function() {
                const estadoId = this.value;

                // Limpiar el select de municipios
                municipioSelect.innerHTML = '<option value="">Seleccionar municipio</option>';

                if (estadoId) {
                    fetch(`/municipios/${estadoId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(municipio => {
                                const option = document.createElement('option');
                                option.value = municipio.description;
                                option.textContent = municipio.description;
                                municipioSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error al cargar municipios:', error));
                }
            });
        }

        // Editar Dirección Fiscal
        document.querySelectorAll('button[data-bs-target="#editFiscalModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const direccionId = this.getAttribute('data-id');
                fetch(`/direccion/${direccionId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('direccion_id').value = data.id;
                        document.getElementById('calle_fiscal_edit').value = data.calle;
                        document.getElementById('numero_ext_fiscal_edit').value = data.numero_ext;
                        document.getElementById('numero_int_fiscal_edit').value = data.numero_int;
                        document.getElementById('colonia_fiscal_edit').value = data.colonia;
                        document.getElementById('codigo_postal_fiscal_edit').value = data.codigo_postal;

                        // Actualizar el estado y cargar los municipios correspondientes
                        const estadoSelectEdit = document.getElementById('entidad_federativa_fiscal_edit');
                        const municipioSelectEdit = document.getElementById('municipio_id_fiscal_edit');

                        estadoSelectEdit.value = data.entidad_federativa_id;
                        fetch(`/municipios/${data.entidad_federativa_id}`)
                            .then(response => response.json())
                            .then(municipios => {
                                municipioSelectEdit.innerHTML = '<option value="">Seleccionar municipio</option>';
                                municipios.forEach(municipio => {
                                    const option = document.createElement('option');
                                    option.value = municipio.description;
                                    option.textContent = municipio.description;
                                    if (municipio.description === data.municipio) {
                                        option.selected = true;
                                    }
                                    municipioSelectEdit.appendChild(option);
                                });
                            });
                    })
                    .catch(error => console.error('Error fetching data:', error));
            });
        });

        // Editar Dirección de Estación
        document.querySelectorAll('button[data-bs-target="#editEstacionModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const direccionId = this.getAttribute('data-id');
                fetch(`/direccion/${direccionId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('direccion_id_estacion').value = data.id;
                        document.getElementById('calle_estacion_edit').value = data.calle;
                        document.getElementById('numero_ext_estacion_edit').value = data.numero_ext;
                        document.getElementById('numero_int_estacion_edit').value = data.numero_int;
                        document.getElementById('colonia_estacion_edit').value = data.colonia;
                        document.getElementById('codigo_postal_estacion_edit').value = data.codigo_postal;

                        // Actualizar el estado y cargar los municipios correspondientes
                        const estadoSelectEdit = document.getElementById('entidad_federativa_estacion_edit');
                        const municipioSelectEdit = document.getElementById('municipio_id_estacion_edit');

                        estadoSelectEdit.value = data.entidad_federativa_id;
                        fetch(`/municipios/${data.entidad_federativa_id}`)
                            .then(response => response.json())
                            .then(municipios => {
                                municipioSelectEdit.innerHTML = '<option value="">Seleccionar municipio</option>';
                                municipios.forEach(municipio => {
                                    const option = document.createElement('option');
                                    option.value = municipio.description;
                                    option.textContent = municipio.description;
                                    if (municipio.description === data.municipio) {
                                        option.selected = true;
                                    }
                                    municipioSelectEdit.appendChild(option);
                                });
                            });
                    })
                    .catch(error => console.error('Error fetching data:', error));
            });
        });
    });
</script>
@endsection