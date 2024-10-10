<div class="col-lg-6 mb-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Dispensarios</h5>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarDispensario">
                <i class="bx bx-plus"></i> Agregar Dispensario
            </button>
        </div>
        <div class="card-body p-3">
            @if($dispensarios->isNotEmpty())
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Número de Isla</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Número de Serie</th>
                        <th>Número de Aprobacion</th>
                        @if(auth()->user()->hasRole('Administrador'))
                        <th class="text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($dispensarios as $dispensario)
                    <tr>
                        <td>{{ $dispensario->num_isla }}</td>
                        <td>{{ $dispensario->marca }}</td>
                        <td>{{ $dispensario->modelo }}</td>
                        <td>{{ $dispensario->numero_serie }}</td>
                        <td>{{ $dispensario->numero_aprobacion }}</td>
                        @if(auth()->user()->hasRole('Administrador'))
                        <td class="text-center">
                            <form action="{{ route('dispensarios.destroy', ['estacion_id' => $estacion->id, 'id' => $dispensario->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este dispensario?');">
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
            <p class="text-center text-muted">No hay dispensarios registrados.</p>
            @endif
        </div>
    </div>
</div>