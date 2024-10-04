@extends('layouts.master')

@section('title')
@lang('Documentación del Servicio - Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Servicios @endslot
@slot('title') Documentación de Medición del Servicio {{ $servicio->nomenclatura }} @endslot
@endcomponent

@include('partials.alertas') <!-- Incluyendo las alertas -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <form action="{{ route('armonia.servicios.anexo_30.documentos.menu') }}" method="GET">
                        <input type="hidden" name="id" value="{{ $servicio->id }}">
                        <button type="submit" class="btn btn-danger">
                            <i class="bx bx-arrow-back"></i>
                        </button>
                    </form>
                </div>

                <!-- Información del Servicio en Dos Columnas -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Información del Servicio</h5>
                        <div class="row">
                            <!-- Columna 1: Datos del Servicio -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-id-card me-2"></i>
                                    <strong>Nomenclatura:</strong>
                                    <span class="ms-1 text-muted">{{ $servicio->nomenclatura }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-building-house me-2"></i>
                                    <strong>Estación:</strong>
                                    <span class="ms-1 text-muted">{{ $servicio->estaciones->first()->razon_social ?? 'Desconocido' }}</span>
                                </div>
                            </div>

                            <!-- Columna 2: Dirección -->
                            <div class="col-md-6">
                                @php
                                $direccion = $servicio->estaciones->first()->domicilioServicio ?? null;
                                @endphp

                                @if($direccion)
                                <div class="row g-1"> <!-- Reducir espacio entre columnas con 'g-1' -->
                                    <!-- Sub-Columna 1 de la Dirección -->
                                    <div class="col-6">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bx bx-street-view me-2"></i>
                                            <strong>Calle:</strong>
                                            <span class="ms-1 text-muted">{{ $direccion->calle ?? 'No especificado' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bx bx-map me-2"></i>
                                            <strong>Núm. Ext:</strong>
                                            <span class="ms-1 text-muted">{{ $direccion->numero_exterior ?? 'S/N' }}</span>
                                        </div>
                                        @if($direccion->numero_interior)
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bx bx-door-open me-2"></i>
                                            <strong>Núm. Int:</strong>
                                            <span class="ms-1 text-muted">{{ $direccion->numero_interior }}</span>
                                        </div>
                                        @endif
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bx bx-map-pin me-2"></i>
                                            <strong>Colonia:</strong>
                                            <span class="ms-1 text-muted">{{ $direccion->colonia ?? 'No especificado' }}</span>
                                        </div>
                                    </div>

                                    <!-- Sub-Columna 2 de la Dirección -->
                                    <div class="col-6">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bx bx-mail-send me-2"></i>
                                            <strong>C.P.:</strong>
                                            <span class="ms-1 text-muted">{{ $direccion->codigo_postal ?? 'No especificado' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bx bx-city me-2"></i>
                                            <strong>Municipio:</strong>
                                            <span class="ms-1 text-muted">{{ $direccion->municipio ?? 'No especificado' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bx bx-globe me-2"></i>
                                            <strong>Estado:</strong>
                                            <span class="ms-1 text-muted">{{ $direccion->entidad_federativa ?? 'No especificado' }}</span>
                                        </div>
                                        @if($direccion->entre_calles)
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bx bx-directions me-2"></i>
                                            <strong>Entre Calles:</strong>
                                            <span class="ms-1 text-muted">{{ $direccion->entre_calles }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <p class="text-muted"><i class="bx bx-error"></i> Dirección no especificada</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Tipo Referencia</th>
                                <th>Acción</th>
                                <th>Descargar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requiredDocuments as $doc)
                            @php
                            $docExists = false;
                            $docUrl = '';
                            $documentId = null;
                            $nombreEsperado = str_replace(' ', '_', $doc['descripcion']);

                            // Comparar el nombre del documento almacenado con el nombre esperado
                            foreach ($documentos as $documento) {
                            if ($documento->nombre === $doc['descripcion']) {
                            $docExists = true;
                            $docUrl = $documento->ruta;
                            $documentId = $documento->id;
                            break;
                            }
                            }
                            @endphp
                            <tr>
                                <td>{{ $doc['descripcion'] }}</td>
                                <td>{{ $doc['tipo'] }}</td>
                                <td>
                                    <!-- Botón de agregar o editar -->
                                    <button type="button" class="btn btn-{{ $docExists ? 'warning' : 'success' }} btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#documentoModal-{{ Str::slug($doc['descripcion']) }}">
                                        <i class="bx bx-{{ $docExists ? 'edit-alt' : 'upload' }}"></i>
                                    </button>

                                    <!-- Botón de eliminar solo si el documento existe -->
                                    @if($docExists)
                                    <form action="{{ route('documentacion.general.delete', $documentId) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres borrar este documento?');">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                                <td>
                                    @if($docExists)
                                    <a href="{{ Storage::url($docUrl) }}" class="btn btn-info btn-sm" download>
                                        <i class="bx bx-download"></i>
                                    </a>
                                    @else
                                    <span>No disponible</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal para agregar o editar documento -->
                            <div class="modal fade" id="documentoModal-{{ Str::slug($doc['descripcion']) }}"
                                tabindex="-1" aria-labelledby="documentoModalLabel-{{ Str::slug($doc['descripcion']) }}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                {{ $docExists ? 'Editar Documento' : 'Agregar Documento' }}: {{ $doc['descripcion'] }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('documentacion.general.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="rutadoc_estacion" class="form-label">Seleccionar Archivo</label>
                                                    <input type="file" name="rutadoc_estacion" class="form-control" required>
                                                </div>
                                                <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
                                                <input type="hidden" name="categoria" value="medicion">
                                                <input type="hidden" name="nombre" value="{{ $doc['descripcion'] }}">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ $docExists ? 'Actualizar Documento' : 'Agregar Documento' }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection