@extends('layouts.master')

@section('title') @lang('Crear Rol') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Roles @endslot
@slot('title') Crear Rol @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre del Rol</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="permissions" class="form-label">Permisos</label>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="select-all" onclick="toggleAllPermissions()">
                            <label class="form-check-label" for="select-all">
                                Seleccionar Todos
                            </label>
                        </div>

                        <div class="row">
                            @foreach($permission as $value)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $value->name }}" id="permission-{{ $value->name }}">
                                    <label class="form-check-label" for="permission-{{ $value->name }}">
                                        {{ $value->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-danger">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAllPermissions() {
        const selectAllCheckbox = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('input[name="permission[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
    }
</script>
@endsection