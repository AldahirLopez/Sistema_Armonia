<form id="generarReporteFotografico" action="{{ route('reporte_fotografico_anexo_30.generar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Hidden Fields -->
    <input type="hidden" name="nomenclatura" value="{{ $servicioAnexo->nomenclatura }}">
    <input type="hidden" name="idestacion" value="{{ $estacion->id }}">
    <input type="hidden" name="id_servicio" value="{{ $servicioAnexo->id }}">
    <input type="hidden" name="id_usuario" value="{{ $servicioAnexo->id_usuario }}">
    <input type="hidden" name="domicilio_servicio_id" value="{{ $estacion->domicilio_servicio_id }}">
    <input type="hidden" name="fecha_inspeccion" class="form-control" value="{{ \Carbon\Carbon::parse($servicioAnexo->date_inspeccion_at)->format('Y-m-d') }}">

    <!-- Modal Body -->
    <div class="modal-body">
    <small class="text-muted">Debe subir al menos 4 imágenes. De lo contrario, no se actualizará su reporte.</small>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach ($categorias_imagen as $categoria)
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-{{ $categoria }}" data-bs-toggle="tab" data-bs-target="#{{ $categoria }}"
                    type="button" role="tab" aria-controls="{{ $categoria }}" aria-selected="false"
                    onclick="cargarImagenes('{{ $categoria }}')">
                    {{ $categoria }}
                </button>
            </li>
            @endforeach
        </ul>

        <!-- Contenedor donde se mostrarán las imágenes -->
        <div class="tab-content mt-3" id="imagenes-content">
            <div id="imagenes" class="row"></div>
        </div>

        <!-- Contenedor para las miniaturas de imágenes seleccionadas -->
        <div class="mt-3">
            <h5>Imágenes seleccionadas:</h5>
            <div id="imagenes-seleccionadas" class="row"></div>
        </div>

        
    </div>

    <!-- Modal Footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Generar</button>
    </div>
</form>

<script>
function cargarImagenes(categoria) {
    const num_estacion = "{{ $estacion->num_estacion }}"; // Obtener el número de la estación
    document.getElementById('imagenes').innerHTML = ''; // Limpiar el contenedor de imágenes anterior

    // Solicitud AJAX para cargar imágenes
    $.ajax({
        url: `/galeria/${num_estacion}/${categoria}`,
        method: 'GET',
        success: function(imagenes) {
            if (imagenes.length > 0) {
                imagenes.forEach(function(imagen) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3';
                    const img = document.createElement('img');
                    img.src = imagen.url;
                    img.className = 'img-fluid';
                    img.style.cursor = 'pointer'; // Hacer que el cursor cambie cuando pase por encima de la imagen

                    // Añadir evento click para seleccionar la imagen
                    img.onclick = function() {
                        seleccionarImagen(imagen);
                    };

                    col.appendChild(img);
                    document.getElementById('imagenes').appendChild(col);
                });
            } else {
                document.getElementById('imagenes').innerHTML = '<p>No hay imágenes para esta categoría.</p>';
            }
        },
        error: function() {
            document.getElementById('imagenes').innerHTML = '<p>Error al cargar las imágenes.</p>';
        }
    });
}

function seleccionarImagen(image) {
    const selectedImagesContainer = document.getElementById('imagenes-seleccionadas');      
    const existingImage = Array.from(selectedImagesContainer.getElementsByTagName('img')).find(img => img.src === image.url);
    if (!existingImage) {
       
        const col = document.createElement('div');
        col.className = 'col-md-3 position-relative';
        const img = document.createElement('img');
        img.src = image.url;
        img.className = 'img-fluid';

        // Create a remove button
        const removeButton = document.createElement('button');
        removeButton.innerHTML = '&times;'; 
        removeButton.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
        removeButton.style.zIndex = 10; 
        removeButton.onclick = function() {
            
            col.remove();
            const hiddenInput = selectedImagesContainer.querySelector(`input[value="${JSON.stringify(image)}"]`);
            if (hiddenInput) {
                hiddenInput.remove();
            }
        };

        col.appendChild(img);
        col.appendChild(removeButton);
        selectedImagesContainer.appendChild(col);

        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'selected_images[]'; 
        input.value = JSON.stringify({
            nombre: image.nombre,
            categoria: image.categoria,
            url: image.url
        });
        
        selectedImagesContainer.appendChild(input);
    } else {
        alert('Esta imagen ya ha sido seleccionada.');
    }
}


</script>
