@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Edición de usuarios</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        @if($errors->any())
                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                            <strong>¡Rellene los campos correctamente!</strong>
                            @foreach($errors->all() as $error)
                            <span class="badge badge-danger">{{$error}}</span>
                            @endforeach
                            <button type="button" class="close" data-dismisss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <!-- Formulario de edición de usuarios -->
                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PATCH') <!-- Para enviar un método PATCH -->

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="permissions">Permisos para este rol</label>
                                        <br />
                                        @foreach($permission as $value)
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $value->name }}"
                                                {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $value->name }}
                                        </label>
                                        <br />
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection