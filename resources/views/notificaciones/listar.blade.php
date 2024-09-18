@extends('layouts.master')

@section('title')
@lang('Notificaciones')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Notificaciones @endslot
@slot('title') Todas las Notificaciones @endslot
@endcomponent
@include('partials.alertas') <!-- Incluyendo las alertas -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Notificaciones</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Servicio</th>
                                <th>Mensaje</th>
                                <th>Usuario</th>
                                <th>Fecha de creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notificaciones as $notificacion)
                            @php
                            $data = $notificacion->data;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['nomenclatura'] }}</td>
                                <td>{{ $data['mensaje'] }}</td>
                                <td>{{ $data['usuario'] ?? 'Desconocido' }}</td>
                                <td>{{ $notificacion->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <!-- Verificación si es para eliminación o aprobación -->
                                    @if($data['pending_deletion_servicio'])
                                    <!-- Formulario para eliminar el servicio -->
                                    <form action="{{ route('eliminar.servicio.anexo', ['id' => $data['servicio_id'], 'notificationId' => $notificacion->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> <!-- Icono de eliminar -->
                                        </button>
                                    </form>
                                    @elseif($data['pending_apro_servicio'] == false)
                                    <!-- Formulario para aprobar el servicio -->
                                    <form action="{{ route('aprobar.servicio.anexo', ['id' => $data['servicio_id'], 'notificationId' => $notificacion->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check"></i><!-- Icono de aprobar -->
                                        </button>
                                    </form>
                                    @endif


                                    <!-- Formulario para eliminar el servicio y la notificación -->
                                    <form action="{{ route('cancelar.servicio.anexo', ['id' => $data['servicio_id'], 'notificationId' => $notificacion->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-info">
                                             Cancelar <!-- Icono de eliminar -->
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay notificaciones disponibles.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection