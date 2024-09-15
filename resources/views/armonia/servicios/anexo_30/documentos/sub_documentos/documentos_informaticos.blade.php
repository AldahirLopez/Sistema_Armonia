@extends('layouts.master')

@section('title')
@lang('Documentación del Servicio - Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Servicios @endslot
@slot('title') Documentación del Sistema Informático del Servicio {{ $servicio->nomenclatura }} @endslot
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
                                                <input type="hidden" name="categoria" value="informatica">
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