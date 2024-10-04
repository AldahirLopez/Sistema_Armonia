@extends('layouts.master')

@section('title')
@lang('Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Selección @endslot
@slot('title') Anexo 30 @endslot
@endcomponent

@include('partials.alertas') <!-- Incluyendo las alertas -->

<!-- Botón para volver y generar nuevo servicio -->
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between">
                <a href="{{ route('documentacion.generarPDF') }}" class="btn btn-primary">
                    <i class="bx bxs-file-pdf"></i> Generar Lista de Requisitos
                </a>
                @if($estaciones->isNotEmpty())
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generarServicioModal">
                    <i class="bx bx-plus-circle"></i> Generar Nuevo Servicio
                </button>
                @else
                <a href="{{ route('estaciones.usuario') }}" class="btn btn-primary">
                    <i class="bx bx-building-house"></i> Registre nuevas estaciones
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Mostrar servicios -->
<div class="row">
    @forelse($servicios as $servicio)
    <div class="col-lg-4 col-md-6 mb-4 d-flex">
        <div class="card border-light shadow-sm h-100 w-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title font-weight-bold text-dark text-truncate">
                    {{ $servicio->nomenclatura }}

                    <!-- Mostrar botón de editar solo si el usuario tiene el rol de 'Administrador' -->
                    @if(auth()->user()->hasRole('Administrador'))
                    <button type="button" class="btn btn-outline-primary btn-sm ms-2 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#actualizarNomenclaturaModal-{{ $servicio->id }}" style="border-radius: 20px;">
                        <i class="bx bx-edit me-1" style="font-size: 1.2rem;"></i> <!-- Icono de editar con tamaño mayor -->
                        <span>Editar</span>
                    </button>
                    @endif
                </h5>
            </div>

            <div class="card-body d-flex flex-column justify-content-between">
                <!-- Estado del servicio -->
                <p class="text-muted">
                    @if($servicio->pending_apro_servicio && $servicio->pending_deletion_servicio==false )
                    <span class="badge bg-success">Aprobado</span>
                    @else
                    @if($servicio->pending_deletion_servicio)
                    <span class="badge bg-warning text-dark"></span>
                    @else
                    <span class="badge bg-warning text-dark">Pendiente de aprobación</span>
                    @endif
                    @endif

                    @if($servicio->pending_deletion_servicio)
                    <span class="badge bg-danger">Eliminación pendiente de aprobación</span>
                    @endif
                </p>

                <!-- Mostrar la estación relacionada con el servicio -->
                <p class="card-text text-muted mb-3">
                    Tipo de Servicio: <strong>{{ $servicio->estaciones->first()->tipo_estacion ?? 'Desconocido' }}</strong><br>
                    Servicio para la estación:
                    <strong>{{ $servicio->estaciones->first()->razon_social ?? 'Desconocido' }}</strong><br>
                    Estado: {{ $servicio->estaciones->first()->domicilioServicio->entidad_federativa ?? 'Estado desconocido' }}<br>
                    Municipio: {{ $servicio->estaciones->first()->domicilioServicio->municipio ?? 'Municipio desconocido' }}
                </p>



                <div class="d-flex justify-content-between align-items-center mt-auto">
                    @if($servicio->pending_deletion_servicio)
                    <!-- Si el servicio tiene pendiente la eliminación, desactivar botones -->
                    <span class="text-muted">Eliminación pendiente de aprobación</span>
                    @else
                    @if($servicio->pending_apro_servicio)
                    <!-- Botones de acción con íconos y estilo más sutil -->
                    <a href="{{ route('armonia.servicios.anexo_30.documentos.menu', ['id' => $servicio->id]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-folder-open"></i> Documentación
                    </a>

                    <a href="{{ route('expediente.index', ['id' => $servicio->id]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-folder-open"></i> Expediente
                    </a>


                    <a href="{{ route('armonia.servicios.anexo_30.listas_inspeccion.menu', ['id' => $servicio->id]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-folder-open"></i> Listas de Inspeccion
                    </a>

                    <form action="{{ route('anexo.destroy', $servicio->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bx bx-trash"></i> Eliminar
                        </button>
                    </form>
                    @else
                    <!-- Si el servicio no está aprobado, solo muestra el mensaje -->
                    <span class="text-muted">Pendiente de aprobación</span>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-lg-12">
        <div class="alert alert-warning text-center">No se encontraron servicios para mostrar.</div>
    </div>
    @endforelse
</div>
<!-- Paginación -->
<div class="d-flex justify-content-center mt-4">
    {{ $servicios->onEachSide(1)->links('pagination::bootstrap-4', ['class' => 'pagination-sm']) }}
</div>

<!-- Modal para generar servicio -->
@include('armonia.servicios.anexo_30.modals.generarServicio', ['estaciones' => $estaciones])
@foreach($servicios as $servicio)
<!-- Modal para actualizar la nomenclatura -->
<div class="modal fade" id="actualizarNomenclaturaModal-{{ $servicio->id }}" tabindex="-1" aria-labelledby="actualizarNomenclaturaLabel-{{ $servicio->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actualizarNomenclaturaLabel-{{ $servicio->id }}">Actualizar Nomenclatura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('servicio-anexo.actualizar-nomenclatura', $servicio->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nuevaNomenclatura-{{ $servicio->id }}" class="form-label">Nueva Nomenclatura</label>
                        <input type="text" class="form-control" id="nuevaNomenclatura-{{ $servicio->id }}" name="nueva_nomenclatura" placeholder="Ingrese la nueva nomenclatura" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


@endsection