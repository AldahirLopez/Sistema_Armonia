@extends('layouts.master')

@section('title') @lang('Roles') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Roles @endslot
@slot('title') Lista de Roles @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                @can('crear-rol')
                <a href="{{ route('roles.create') }}" class="btn btn-warning">Nuevo</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Rol</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @can('editar-rol')
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-info">Editar</a>
                                    @endcan

                                    @can('borrar-rol')
                                    <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este rol?');">Borrar</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination justify-content-end">
                    {{ $roles->links() }}
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
@endsection