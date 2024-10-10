<div class="col-lg-6 mb-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Sondas</h5>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarSondas">
                <i class="bx bx-plus"></i> Agregar Sonda
            </button>
        </div>
        <div class="card-body p-3">
            @if($sondas->isNotEmpty())
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Número de Serie</th>
                        <th>Producto</th>
                        <th>Marca</th>
                        @if(auth()->user()->hasRole('Administrador'))
                        <th>Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($sondas as $sonda)
                    <tr>
                        <td>{{ $sonda->folio }}</td>
                        <td>{{ $sonda->numero_serie }}</td>
                        <td>{{ $sonda->producto }}</td>
                        <td>{{ $sonda->marca }}</td>
                        @if(auth()->user()->hasRole('Administrador'))
                        <td class="text-center">
                            <form action="{{ route('sondas.destroy', ['estacion_id' => $estacion->id, 'id' => $sonda->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta sonda?');">
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
            <p class="text-center text-muted">No hay sondas registradas.</p>
            @endif
        </div>
    </div>
</div>