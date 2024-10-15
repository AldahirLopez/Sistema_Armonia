<div>
    @if(!empty($existingFiles))
    <h4>Archivos Existentes:</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre del Archivo</th>
                <th>PDF</th> <!-- Columna para descargar en PDF -->
                <th>Word</th> <!-- Columna para descargar en Word -->
            </tr>
        </thead>
        <tbody>
            @foreach($existingFiles as $file)
            <tr>
                <td>{{ basename($file['name']) }}</td> <!-- Mostrar solo el nombre del archivo -->

                <!-- Columna para descargar en PDF -->
                <td class="text-center">
                    <!-- Botón para convertir y descargar el archivo DOCX como PDF -->
                    <a href="{{ route('convertir.pdf', ['filePath' => $file['name']]) }}" class="btn btn-outline-danger btn-sm" title="Descargar como PDF">
                        <i class="fas fa-file-pdf fa-2x"></i> <!-- Ícono agrandado para PDF -->
                    </a>
                </td>

                <!-- Columna para descargar en Word -->
                <td class="text-center">
                    <a href="{{ $file['url'] }}" class="btn btn-outline-primary btn-sm" title="Descargar en Word" download>
                        <i class="fas fa-file-word fa-2x"></i> <!-- Ícono agrandado para Word -->
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No hay archivos existentes.</p>
    @endif
</div>