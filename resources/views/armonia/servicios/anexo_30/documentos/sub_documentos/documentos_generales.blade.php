@extends('layouts.master')

@section('title')
@lang('Documentación General - Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Documentación @endslot
@slot('title') Documentación General - Anexo 30 @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">LISTA DE DOCUMENTOS GENERALES REQUERIDOS ANEZO 30 Y 31 RMF 2024
                    {{ $servicio->nomenclatura }}
                </h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <form action="{{ route('documentacion_anexo') }}" method="GET" style="display:inline;">
                        <input type="hidden" name="id" value="{{ $servicio->id }}">
                        <button type="submit" class="btn btn-danger">
                            <i class="bx bx-arrow-back"></i> Volver
                        </button>
                    </form>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">DESCRIPCIÓN</th>
                            <th scope="col">TIPO REFERENCIA</th>
                            @can('Generar-documentacion-anexo_30')
                            <th scope="col">Agregar</th>
                            @endcan
                            <th scope="col">Descargar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requiredDocuments as $doc)
                        <tr>
                            <td>{{ $doc['descripcion'] }}</td>
                            <td>{{ $doc['tipo'] }}</td>
                            @can('Generar-documentacion-anexo_30')
                            <td>
                                <!-- Botón que abre el modal para agregar nuevo documento -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#agregarDocumentoModal-{{ Str::slug($doc['descripcion']) }}">
                                    <i class="bx bx-upload"></i> Agregar
                                </button>
                            </td>
                            @endcan
                            <td>
                                @php
                                $docExists = false;
                                $docUrl = '';
                                foreach ($documentos as $documento) {
                                if ($documento->nombre === $doc['descripcion']) {
                                $docExists = true;
                                $docUrl = $documento->ruta;
                                break;
                                }
                                }
                                @endphp
                                @if($docExists)
                                <a href="{{ $docUrl }}" class="btn btn-info" target="_blank"><i class="bx bx-download"></i> Descargar</a>
                                @else
                                <span>No disponible</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal para agregar documento -->
                        @can('Generar-documentacion-anexo_30')
                        <div class="modal fade" id="agregarDocumentoModal-{{ Str::slug($doc['descripcion']) }}"
                            tabindex="-1" role="dialog" aria-labelledby="agregarDocumentoLabel-{{ Str::slug($doc['descripcion']) }}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="agregarDocumentoLabel-{{ Str::slug($doc['descripcion']) }}">
                                            Agregar Documento: {{ $doc['descripcion'] }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('documentacion_anexo_general.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="rutadoc_estacion">Seleccionar Archivo</label>
                                                <input type="file" name="rutadoc_estacion" class="form-control" required>
                                            </div>
                                            <input type="hidden" name="servicio_id" value="{{ $id }}">
                                            <input type="hidden" name="id_documento" value="{{ $doc['id'] }}">
                                            <input type="hidden" name="nomenclatura" value="{{ $servicio->nomenclatura }}">
                                            <input type="hidden" name="nombre" value="{{ $doc['descripcion'] }}">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Agregar Documento</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection