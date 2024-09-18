@extends('layouts.master')

@section('title')
@lang('Notificación de Servicio Pendiente - Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Notificaciones @endslot
@slot('title') Servicio Pendiente - Anexo 30 @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Notificación de {{ $data['nomenclatura'] }}
                @if($data['pending_deletion_servicio'])
                Pendiente de Eliminación
                @elseif($data['pending_apro_servicio'] == false)
                Pendiente de Aprobación
                @endif
            </div>
            <div class="card-body">
                <h5 class="card-title">Nomenclatura: {{ $data['nomenclatura'] }}</h5>
                <p class="card-text">{{ $data['mensaje'] }}</p>
                <p>Solicitado por: {{ $data['usuario'] }}</p>
                <p>Fecha de creación: {{ $notification->created_at->format('d/m/Y H:i:s') }}</p>

                <!-- Acciones según el tipo de servicio -->
                <form action="{{ $data['pending_deletion_servicio'] 
                    ? route('eliminar.servicio.anexo', ['id' => $data['servicio_id'], 'notificationId' => $notification->id])
                    : route('aprobar.servicio.anexo', ['id' => $data['servicio_id'], 'notificationId' => $notification->id]) }}"
                    method="POST">
                    @csrf
                    <!-- Botón depende del tipo de notificación -->
                    @if($data['pending_deletion_servicio'])
                    <button type="submit" class="btn btn-danger">Eliminar Servicio</button>
                    @elseif($data['pending_apro_servicio'] == false)
                    <button type="submit" class="btn btn-success">Aprobar Servicio</button>
                    @endif
                    <a href="{{ route('notificaciones.listar') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection