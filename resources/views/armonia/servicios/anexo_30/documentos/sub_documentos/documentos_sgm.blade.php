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
                <button type="submit" class="btn btn-danger">
                    <i class="bx bx-arrow-back"></i>
                </button>
            </form>
        </div>

        <!-- Botones para abrir modales de subida -->
        <div class="mb-3">
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalUpload" data-categoria="manual">Subir Manual</button>
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalUpload" data-categoria="procedimientos">Subir Procedimientos</button>
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalUpload" data-categoria="formatos">Subir Formatos</button>
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalUpload" data-categoria="constancia">Subir Constancia de Capacitación</button>
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalUpload" data-categoria="certificados">Subir Certificados de Calibración</button>
        </div>

        <!-- Tabla de Manuales -->
        <h6>Manuales</h6>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de Subida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($manuales as $manual)
                <tr>
                    <td>{{ $manual->nombre }}</td>
                    <td>{{ $manual->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ Storage::url($manual->ruta) }}" target="_blank" class="btn btn-info btn-sm">Ver</a>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $manual->id }}">Editar</button>
                        <form action="{{ route('documentacionsgm.destroy', $manual->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <!-- Modal para editar manual -->
                <div class="modal fade" id="modalEdit-{{ $manual->id }}" tabindex="-1" aria-labelledby="modalEditLabel-{{ $manual->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalEditLabel-{{ $manual->id }}">Editar Manual</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('documentacion.sgm.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Seleccionar Nuevo Archivo</label>
                                        <input type="file" name="file" class="form-control" required>
                                    </div>

                                    <!-- Campos ocultos -->
                                    <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
                                    <input type="hidden" name="categoria" value="manual">
                                    <input type="hidden" name="documento_id" value="{{ $manual->id }}">

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Actualizar Documento</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

        <!-- Tabla de Procedimientos -->
        <h6>Procedimientos</h6>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de Subida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($procedimientos as $procedimiento)
                <tr>
                    <td>{{ $procedimiento->nombre }}</td>
                    <td>{{ $procedimiento->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ Storage::url($procedimiento->ruta) }}" target="_blank" class="btn btn-info btn-sm">Ver</a>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $procedimiento->id }}">Editar</button>
                        <form action="{{ route('documentacionsgm.destroy', $procedimiento->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <!-- Modal para editar procedimiento -->
                <div class="modal fade" id="modalEdit-{{ $procedimiento->id }}" tabindex="-1" aria-labelledby="modalEditLabel-{{ $procedimiento->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalEditLabel-{{ $procedimiento->id }}">Editar Procedimiento</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('documentacion.sgm.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Seleccionar Nuevo Archivo</label>
                                        <input type="file" name="file" class="form-control" required>
                                    </div>

                                    <!-- Campos ocultos -->
                                    <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
                                    <input type="hidden" name="categoria" value="procedimientos">
                                    <input type="hidden" name="documento_id" value="{{ $procedimiento->id }}">

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Actualizar Documento</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

        <!-- Tabla de Formatos -->
        <h6>Formatos</h6>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de Subida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($formatos as $formato)
                <tr>
                    <td>{{ $formato->nombre }}</td>
                    <td>{{ $formato->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ Storage::url($formato->ruta) }}" target="_blank" class="btn btn-info btn-sm">Ver</a>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $formato->id }}">Editar</button>
                        <form action="{{ route('documentacionsgm.destroy', $formato->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <!-- Modal para editar formato -->
                <div class="modal fade" id="modalEdit-{{ $formato->id }}" tabindex="-1" aria-labelledby="modalEditLabel-{{ $formato->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalEditLabel-{{ $formato->id }}">Editar Formato</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('documentacion.sgm.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Seleccionar Nuevo Archivo</label>
                                        <input type="file" name="file" class="form-control" required>
                                    </div>

                                    <!-- Campos ocultos -->
                                    <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
                                    <input type="hidden" name="categoria" value="formatos">
                                    <input type="hidden" name="documento_id" value="{{ $formato->id }}">

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Actualizar Documento</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

        <!-- Tabla de Constancias de Capacitación -->
        <h6>Constancias de Capacitación</h6>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de Subida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($capacitaciones as $capacitacion)
                <tr>
                    <td>{{ $capacitacion->nombre }}</td>
                    <td>{{ $capacitacion->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ Storage::url($capacitacion->ruta) }}" target="_blank" class="btn btn-info btn-sm">Ver</a>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $capacitacion->id }}">Editar</button>
                        <form action="{{ route('documentacionsgm.destroy', $capacitacion->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <!-- Modal para editar constancia -->
                <div class="modal fade" id="modalEdit-{{ $capacitacion->id }}" tabindex="-1" aria-labelledby="modalEditLabel-{{ $capacitacion->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalEditLabel-{{ $capacitacion->id }}">Editar Constancia</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('documentacion.sgm.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Seleccionar Nuevo Archivo</label>
                                        <input type="file" name="file" class="form-control" required>
                                    </div>

                                    <!-- Campos ocultos -->
                                    <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
                                    <input type="hidden" name="categoria" value="Constancia">
                                    <input type="hidden" name="documento_id" value="{{ $capacitacion->id }}">

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Actualizar Documento</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

        <!-- Tabla de Certificados de Calibración -->
        <h6>Certificados de Calibración</h6>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de Subida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($certificados as $certificado)
                <tr>
                    <td>{{ $certificado->nombre }}</td>
                    <td>{{ $certificado->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ Storage::url($certificado->ruta) }}" target="_blank" class="btn btn-info btn-sm">Ver</a>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $certificado->id }}">Editar</button>
                        <form action="{{ route('documentacionsgm.destroy', $certificado->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <!-- Modal para editar certificado -->
                <div class="modal fade" id="modalEdit-{{ $certificado->id }}" tabindex="-1" aria-labelledby="modalEditLabel-{{ $certificado->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalEditLabel-{{ $certificado->id }}">Editar Certificado</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('documentacion.sgm.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Seleccionar Nuevo Archivo</label>
                                        <input type="file" name="file" class="form-control" required>
                                    </div>

                                    <!-- Campos ocultos -->
                                    <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
                                    <input type="hidden" name="categoria" value="Certificados">
                                    <input type="hidden" name="documento_id" value="{{ $certificado->id }}">

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Actualizar Documento</button>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Subir Documento</button>
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