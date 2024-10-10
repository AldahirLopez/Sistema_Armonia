<div class="col-lg-6 mb-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Tanques</h5>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarTanques">
                <i class="bx bx-plus"></i> Agregar Tanques
            </button>
        </div>
        <div class="card-body p-3">
            @if($tanques->isNotEmpty())
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Folio</th>
                        <th>Serie</th>
                        <th>Marca</th>
                        <th>Producto</th>
                        <th>Capacidad (L)</th>
                        @if(auth()->user()->hasRole('Administrador'))
                        <th class="text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($tanques as $tanque)
                    <tr>
                        <td>{{ $tanque->folio }}</td>
                        <td>{{ $tanque->numero_serie }}</td>
                        <td>{{ $tanque->marca }}</td>
                        <td>{{ $tanque->producto }}</td>
                        <td>{{ $tanque->capacidad }}</td>
                        @if(auth()->user()->hasRole('Administrador'))
                        <td class="text-center">
                            <form action="{{ route('tanques.destroy', ['estacion_id' => $estacion->id, 'id' => $tanque->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este tanque?');">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-center text-muted">No hay tanques registrados.</p>
            @endif
        </div>
    </div>
</div>