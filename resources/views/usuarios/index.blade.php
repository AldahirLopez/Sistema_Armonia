@extends('layouts.master')

@section('title') @lang('Usuarios') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Usuarios @endslot
@slot('title') Lista de Usuarios @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                @can('gestionar-usuarios-crear')
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">Nuevo</button>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-striped">
                        <thead>
                            <tr>
                                <th scope="col" style="display: none;">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                            <tr>
                                <td style="display: none;">{{$usuario->id}}</td>
                                <td>{{$usuario->name}}</td>
                                <td>{{$usuario->email}}</td>
                                <td>
                                    @if($usuario->getRoleNames()->isNotEmpty())
                                    @foreach($usuario->getRoleNames() as $rolname)
                                    <div class="badge bg-success mb-3">{{ $rolname }}</div>
                                    @endforeach
                                    @else
                                    <span class="text-muted">Sin rol asignado</span>
                                    @endif
                                </td>
                                <td>
                                    @can('gestionar-usuarios-editar')
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal-{{$usuario->id}}"><i class="bx bx-pencil"></i></button>
                                    @endcan

                                    @can('gestionar-usuarios-eliminar')
                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');"> <i class="bx bx-trash"></i></button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>

                            <!-- Incluir el modal de edición para cada usuario -->
                            @include('usuarios.editar', ['usuario' => $usuario, 'roles' => $roles, 'userRoles' => $usuario->roles->pluck('id')->toArray()])
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $usuarios->links() !!}
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>

<!-- Modal para crear nuevo usuario -->
<div class="modal fade" id="nuevoUsuarioModal" tabindex="-1" aria-labelledby="nuevoUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success-subtle">
                <h5 class="modal-title" id="nuevoUsuarioModalLabel">Alta de usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenido del formulario de alta de usuarios -->
                @include('usuarios.crear') <!-- Aquí incluimos el formulario dentro del modal -->
            </div>
        </div>
    </div>
</div>
@endsection