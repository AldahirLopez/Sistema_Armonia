<div class="modal fade" id="editarUsuarioModal-{{$usuario->id}}" tabindex="-1" aria-labelledby="editarUsuarioModalLabel-{{$usuario->id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title" id="editarUsuarioModalLabel-{{$usuario->id}}">Edición de usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenido del formulario de edición de usuarios -->
                <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" value="{{ old('name', $usuario->name) }}" class="form-control" id="name">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="text" name="email" value="{{ old('email', $usuario->email) }}" class="form-control" id="email">
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
                                <select name="roles" class="form-control" id="roles" style="appearance: auto;">
                                    @foreach($roles as $roleId => $roleName)
                                    <option value="{{ $roleId }}" {{ old('roles', $userRoles) == $roleId ? 'selected' : '' }}>
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
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>