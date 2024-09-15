<div>
    @if(!empty($existingFiles))
    <h4>Archivos Existentes:</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th></th>
                <th>Nombre del Archivo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($existingFiles as $file)
            <tr>
                <td><i class="bi bi-file-earmark"></i></td>
                <td>{{ basename($file['name']) }}</td>
                <td><a href="{{ route('descargar.archivo', ['archivo' => basename($file['name'])]) }}" class="btn btn-info" download>Descargar</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No hay archivos existentes.</p>
    @endif
</div>
