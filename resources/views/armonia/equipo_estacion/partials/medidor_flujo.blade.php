<div class="col-lg-6 mb-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Medidor de Flujo</h5>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarMedidorFlujo">
                <i class="bx bx-plus"></i> Agregar Medidor de Flujo
            </button>
        </div>
        <div class="card-body p-3">
            @if($medidoresFlujo->isNotEmpty())
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Marca</th>
                        <th>Número de Serie</th>
                        @if(auth()->user()->hasRole('Administrador'))
                        <th class="text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($medidoresFlujo as $medidorFlujo)
                    <tr>
                        <td>{{ $medidorFlujo->marca }}</td>
                        <td>{{ $medidorFlujo->numero_serie }}</td>
                        @if(auth()->user()->hasRole('Administrador'))
                        <td class="text-center">
                            <form action="{{ route('medidor-flujo.destroy', ['estacion_id' => $estacion->id, 'id' => $medidorFlujo->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este Medidor de Flujo?');">
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
            <p class="text-center text-muted">No hay registros de Medidor de Flujo.</p>
            @endif
        </div>
    </div>
</div>