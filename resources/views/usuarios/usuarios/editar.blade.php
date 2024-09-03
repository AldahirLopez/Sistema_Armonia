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
                            <span class="badge badge-danger">{{ $error }}</span>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('usuarios.update', $user->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" id="name">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="text" name="email" value="{{ old('email', $user->email) }}" class="form-control" id="email">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" id="password">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="confirm-password">Confirmar Password</label>
                                        <input type="password" name="confirm-password" class="form-control" id="confirm-password">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="roles">Roles</label>
                                        <select name="roles[]" class="form-control" id="roles" multiple>
                                            @foreach($roles as $roleId => $roleName)
                                            <option value="{{ $roleId }}" {{ in_array($roleId, old('roles', $userRoles)) ? 'selected' : '' }}>
                                                {{ $roleName }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div style="margin-top: 15px;">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a href="{{ route('usuarios.index') }}" class="btn btn-danger">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection