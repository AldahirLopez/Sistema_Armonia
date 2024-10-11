@extends('layouts.master')

@section('title')
@lang('Sistema de Gestión de Medición (SGM)')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Servicios @endslot
@slot('title') Sistema de Gestión de Medición (SGM) @endslot
@endcomponent

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-4">
            <form action="{{ route('armonia.servicios.anexo_30.documentos.menu') }}" method="GET">
                <input type="hidden" name="id" value="{{ $servicio->id }}">
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bx bx-arrow-back"></i>
                </button>
            </form>
        </div>

        <!-- Sección con tablas independientes y botones pequeños -->

        <!-- Tabla de Manuales -->
        <div class="mb-4">
            <h6>Manuales</h6>
            <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalUpload" data-categoria="manual">
                <i class="bx bx-upload"></i> Subir Manual
            </button>
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($manuales as $manual)
                    <tr>
                        <td>{{ $manual->nombre }}</td>
                        <td class="text-center">
                            <a href="{{ Storage::url($manual->ruta) }}" target="_blank" class="btn btn-info btn-sm" title="Ver">
                                <i class="bx bx-show"></i>
                            </a>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $manual->id }}" title="Editar">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <form action="{{ route('documentacionsgm.destroy', $manual->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tabla de Procedimientos -->
        <div class="mb-4">
            <h6>Procedimientos</h6>
            <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalUpload" data-categoria="procedimientos">
                <i class="bx bx-upload"></i> Subir Procedimientos
            </button>
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($procedimientos as $procedimiento)
                    <tr>
                        <td>{{ $procedimiento->nombre }}</td>
                        <td class="text-center">
                            <a href="{{ Storage::url($procedimiento->ruta) }}" target="_blank" class="btn btn-info btn-sm" title="Ver">
                                <i class="bx bx-show"></i>
                            </a>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $procedimiento->id }}" title="Editar">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <form action="{{ route('documentacionsgm.destroy', $procedimiento->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tabla de Formatos -->
        <div class="mb-4">
            <h6>Formatos</h6>
            <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalUpload" data-categoria="formatos">
                <i class="bx bx-upload"></i> Subir Formatos
            </button>
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($formatos as $formato)
                    <tr>
                        <td>{{ $formato->nombre }}</td>
                        <td class="text-center">
                            <a href="{{ Storage::url($formato->ruta) }}" target="_blank" class="btn btn-info btn-sm" title="Ver">
                                <i class="bx bx-show"></i>
                            </a>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $formato->id }}" title="Editar">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <form action="{{ route('documentacionsgm.destroy', $formato->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tabla de Constancias de Capacitación -->
        <div class="mb-4">
            <h6>Constancias de Capacitación</h6>
            <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalUpload" data-categoria="constancia">
                <i class="bx bx-upload"></i> Subir Constancia de Capacitación
            </button>
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($capacitaciones as $capacitacion)
                    <tr>
                        <td>{{ $capacitacion->nombre }}</td>
                        <td class="text-center">
                            <a href="{{ Storage::url($capacitacion->ruta) }}" target="_blank" class="btn btn-info btn-sm" title="Ver">
                                <i class="bx bx-show"></i>
                            </a>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $capacitacion->id }}" title="Editar">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <form action="{{ route('documentacionsgm.destroy', $capacitacion->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tabla de Certificados de Calibración -->
        <div class="mb-4">
            <h6>Certificados de Calibración</h6>
            <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalUpload" data-categoria="certificados">
                <i class="bx bx-upload"></i> Subir Certificados de Calibración
            </button>
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($certificados as $certificado)
                    <tr>
                        <td>{{ $certificado->nombre }}</td>
                        <td class="text-center">
                            <a href="{{ Storage::url($certificado->ruta) }}" target="_blank" class="btn btn-info btn-sm" title="Ver">
                                <i class="bx bx-show"></i>
                            </a>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $certificado->id }}" title="Editar">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <form action="{{ route('documentacionsgm.destroy', $certificado->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para subir archivos -->
<div class="modal fade" id="modalUpload" tabindex="-1" aria-labelledby="modalUploadLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalUploadLabel">Subir Documento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('documentacion.sgm.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Seleccionar Archivo</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>

                    <!-- Campos ocultos para identificar la categoría -->
                    <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
                    <input type="hidden" name="categoria" id="modalCategoria" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-sm">Subir Documento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Manejar el evento al abrir el modal para establecer la categoría
    const modalUpload = document.getElementById('modalUpload');
    modalUpload.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const categoria = button.getAttribute('data-categoria');
        document.getElementById('modalCategoria').value = categoria;
        document.getElementById('modalUploadLabel').textContent = 'Subir ' + categoria.charAt(0).toUpperCase() + categoria.slice(1);
    });
</script>

@endsection