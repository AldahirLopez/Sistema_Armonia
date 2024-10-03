@extends('layouts.master')

@section('title')
@lang('Documentación del Servicio - Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Servicios @endslot
@slot('title') Documentación General del Servicio {{ $servicio->nomenclatura }} @endslot
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

                <!-- Información del Servicio -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Información del Servicio</h5>
                        <p class="mb-1"><strong>Nomenclatura:</strong> {{ $servicio->nomenclatura }}</p>
                        <p class="mb-1"><strong>Estación:</strong> {{ $servicio->estaciones->first()->razon_social ?? 'Desconocido' }}</p>
                        <p class="mb-1"><strong>Estado:</strong> {{ $servicio->estaciones->first()->domicilioServicio->entidad_federativa ?? 'Estado desconocido' }}</p>
                        <p class="mb-1"><strong>Municipio:</strong> {{ $servicio->estaciones->first()->domicilioServicio->municipio ?? 'Municipio desconocido' }}</p>
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

                            // Verificar si existe un documento en la base de datos que coincida con la categoría y nombre
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
                                    <a href="{{ $docUrl }}" class="btn btn-info btn-sm" download>
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
                                                <input type="hidden" name="categoria" value="generales">
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