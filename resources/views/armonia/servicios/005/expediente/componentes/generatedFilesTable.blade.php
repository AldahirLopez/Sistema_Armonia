<div>
    @if(!empty($existingFiles))
    <h4>Archivos Existentes:</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tipo</th> <!-- Nueva columna para el ícono -->
                <th>Nombre del Archivo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($existingFiles as $file)
            <tr>
                <td>
                    <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                        @php
                        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                        @endphp

                        @if($extension === 'pdf')
                        <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 2rem;"></i> <!-- Ícono para PDF -->
                        @elseif(in_array($extension, ['doc', 'docx']))
                        <i class="fas fa-file-word text-primary" style="font-size: 2rem;"></i> <!-- Ícono para Word -->
                        @elseif($extension === 'json')
                        <i class="bx bxs-file-json text-warning" style="font-size: 2rem;"></i> <!-- Ícono para JSON -->
                        @else
                        <i class="bi bi-file-earmark" style="font-size: 2rem;"></i> <!-- Ícono genérico -->
                        @endif
                    </div>
                </td>
                <td>{{ basename($file['name']) }}</td> <!-- Mostrar solo el nombre del archivo -->
                <td><a href="{{ $file['url'] }}" class="btn btn-info" download><i class="bx bxs-cloud-download"></i></a></td> <!-- Descargar archivo -->
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No hay archivos existentes.</p>
    @endif
</div>