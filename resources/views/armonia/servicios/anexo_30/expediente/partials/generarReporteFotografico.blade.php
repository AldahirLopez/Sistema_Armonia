<form id="generarReporteFotografico" action="{{ route('reporte_fotografico_anexo_30.generar') }}" method="POST" enctype="multipart/form-data" class="card shadow-lg border-0 rounded-3">
    @csrf
    <div class="card-body p-4">
        <!-- Hidden Fields -->
        <input type="hidden" name="nomenclatura" value="{{ $servicioAnexo->nomenclatura }}">
        <input type="hidden" name="idestacion" value="{{ $estacion->id }}">
        <input type="hidden" name="id_servicio" value="{{ $servicioAnexo->id }}">
        <input type="hidden" name="id_usuario" value="{{ $servicioAnexo->id_usuario }}">
        <input type="hidden" name="domicilio_servicio_id" value="{{ $estacion->domicilio_servicio_id }}">
        <input type="hidden" name="fecha_inspeccion" value="{{ \Carbon\Carbon::parse($servicioAnexo->date_inspeccion_at)->format('Y-m-d') }}">

        <!-- Instructions -->
        <p class="text-muted fst-italic mb-4">Debe subir al menos 4 imágenes para actualizar su reporte.</p>

        <!-- Nav Tabs -->
        <ul class="nav nav-tabs mb-3" id="imageCategoryTabs" role="tablist">
            @foreach ($categorias_imagen as $categoria)
            <li class="nav-item" role="presentation">
                <button class="nav-link text-uppercase fw-bold" id="tab-{{ $categoria }}" data-bs-toggle="tab" data-bs-target="#categoria-{{ $categoria }}"
                    type="button" role="tab" aria-controls="categoria-{{ $categoria }}" aria-selected="false"
                    onclick="cargarImagenes('{{ $categoria }}')">
                    {{ $categoria }}
                </button>
            </li>
            @endforeach
        </ul>

        <!-- Image Gallery -->
        <div class="tab-content mt-3" id="imagenes-content">
            <div id="imagenes" class="row g-3"></div>
        </div>

        <!-- Selected Images Thumbnails -->
        <div class="mt-4">
            <h5 class="fw-bold mb-3">Imágenes seleccionadas:</h5>
            <div id="imagenes-seleccionadas" class="row g-3"></div>
            <!-- Message if image is already selected -->
            <div id="error-message" class="alert alert-danger mt-3 d-none"></div>
        </div>
    </div>

    <!-- Modal Footer -->
    <div class="card-footer bg-light d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
            <i class="mdi mdi-close-circle-outline"></i> Cerrar
        </button>
        <button type="submit" class="btn btn-success" id="guardarReporteBtn" disabled>
            <i class="mdi mdi-content-save"></i> Guardar Reporte
        </button>
    </div>
</form>

<!-- Custom CSS for Checkmark Circle -->
<style>
    .image-container {
        position: relative;
        width: 100%;
        padding-top: 100%;
        /* Aspect ratio 1:1 */
        overflow: hidden;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .image-container:hover {
        transform: scale(1.05);
    }

    .image-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Ensures uniform image display */
    }

    .image-container .checkmark {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        background-color: rgba(0, 128, 0, 0.7);
        border-radius: 50%;
        display: none;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 18px;
        z-index: 2;
    }

    .image-container.selected .checkmark {
        display: flex;
    }

    /* Styles for the delete button on selected images */
    .selected-image-container {
        position: relative;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .selected-image-container img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .selected-image-container .delete-button {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(255, 0, 0, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        font-size: 16px;
        cursor: pointer;
        z-index: 3;
    }

    .alert-danger {
        padding: 10px;
        display: block;
    }
</style>

<script>
    function cargarImagenes(categoria) {
        const num_estacion = "{{ $estacion->num_estacion }}";
        document.getElementById('imagenes').innerHTML = ''; // Limpiar contenedor de imágenes

        // AJAX request para cargar imágenes
        $.ajax({
            url: `/galeria/${num_estacion}/${categoria}`,
            method: 'GET',
            success: function(imagenes) {
                if (imagenes.length > 0) {
                    imagenes.forEach(function(imagen) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3';

                        // Image container with checkmark
                        const container = document.createElement('div');
                        container.className = 'image-container';

                        const img = document.createElement('img');
                        img.src = imagen.url;
                        img.alt = imagen.nombre;

                        // Checkmark element
                        const checkmark = document.createElement('div');
                        checkmark.className = 'checkmark';
                        checkmark.innerHTML = '&#10003;'; // Unicode for checkmark

                        // Click event for selecting image
                        container.onclick = function() {
                            seleccionarImagen(imagen, container);
                        };

                        container.appendChild(img);
                        container.appendChild(checkmark);
                        col.appendChild(container);
                        document.getElementById('imagenes').appendChild(col);
                    });
                } else {
                    document.getElementById('imagenes').innerHTML = '<p class="text-muted">No hay imágenes disponibles en esta categoría.</p>';
                }
            },
            error: function() {
                document.getElementById('imagenes').innerHTML = '<p class="text-danger">Error al cargar las imágenes.</p>';
            }
        });
    }

    function seleccionarImagen(image, container) {
        const selectedImagesContainer = document.getElementById('imagenes-seleccionadas');
        const errorMessage = document.getElementById('error-message');
        const alreadySelected = document.querySelector(`input[data-url="${image.url}"]`);
        const guardarReporteBtn = document.getElementById('guardarReporteBtn');

        // Si la imagen ya está seleccionada, mostrar mensaje de error y no agregarla
        if (alreadySelected) {
            errorMessage.textContent = "La imagen ya ha sido seleccionada.";
            errorMessage.classList.remove('d-none'); // Mostrar el mensaje
            setTimeout(() => {
                errorMessage.classList.add('d-none'); // Ocultar después de 3 segundos
            }, 3000);
            return;
        }

        // Crear el contenedor de la imagen seleccionada si no está repetida
        const col = document.createElement('div');
        col.className = 'col-md-3 selected-image-container position-relative';

        const img = document.createElement('img');
        img.src = image.url;
        img.alt = image.nombre;
        img.className = 'img-fluid';

        // Create delete button
        const deleteButton = document.createElement('button');
        deleteButton.className = 'delete-button';
        deleteButton.innerHTML = '&times;'; // Unicode for X (delete)
        deleteButton.onclick = function() {
            col.remove();
            const hiddenInput = selectedImagesContainer.querySelector(`input[data-url="${image.url}"]`);
            if (hiddenInput) {
                hiddenInput.remove();
            }
            // Remove selected state and hide the checkmark
            container.classList.remove('selected');
            container.querySelector('.checkmark').style.display = 'none';

            toggleGuardarButton();
        };

        // Create hidden input to store selected image data
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'selected_images[]';
        input.value = JSON.stringify({
            nombre: image.nombre,
            categoria: image.categoria,
            url: image.url
        });
        input.setAttribute('data-url', image.url); // Add data-url attribute to locate it later

        col.appendChild(img);
        col.appendChild(deleteButton); // Append the delete button
        selectedImagesContainer.appendChild(col);
        selectedImagesContainer.appendChild(input);

        // Marcar la imagen como seleccionada
        container.classList.add('selected');
        container.querySelector('.checkmark').style.display = 'flex';
        toggleGuardarButton();
    }

    function toggleGuardarButton() {
    const selectedImages = document.querySelectorAll('#imagenes-seleccionadas .selected-image-container');
    const guardarReporteBtn = document.getElementById('guardarReporteBtn');

    if (selectedImages.length >= 4) {
        guardarReporteBtn.removeAttribute('disabled');
    } else {
        guardarReporteBtn.setAttribute('disabled', true);
    }
}
</script>