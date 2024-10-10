<div class="col-lg-6 mb-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Veeder-Root</h5>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarVeederRoot">
                <i class="bx bx-plus"></i> Agregar Veeder-Root
            </button>
        </div>
        <div class="card-body p-3">
            @if($veederRoots->isNotEmpty())
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Número de Serie</th>
                        @if(auth()->user()->hasRole('Administrador'))
                        <th class="text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($veederRoots as $veederRoot)
                    <tr>
                        <td>{{ $veederRoot->marca }}</td>
                        <td>{{ $veederRoot->modelo }}</td>
                        <td>{{ $veederRoot->numero_serie }}</td>
                        @if(auth()->user()->hasRole('Administrador'))
                        <td class="text-center">
                            <form action="{{ route('veeder-root.destroy', ['estacion_id' => $estacion->id, 'id' => $veederRoot->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este registro Veeder-Root?');">
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
            <p class="text-center text-muted">No hay registros de Veeder-Root.</p>
            @endif
        </div>
    </div>
</div>