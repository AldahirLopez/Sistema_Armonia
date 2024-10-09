@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Estaciones @endslot
@slot('title') Galería @endslot
@endcomponent

@include('partials.alertas') <!-- Incluyendo las alertas -->

<div class="d-flex justify-content-between align-items-center mb-4">
    <!-- Botón de regreso -->
    <a href="{{ route('estaciones.usuario') }}" class="btn btn-danger">
        <i class="bx bx-arrow-back"></i>
    </a>
    <h4 class="mb-0">Galería de Imágenes</h4>

    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#storeImage" data-bs-placement="top" title="Agregar imagen">
        <i class="fas fa-plus"></i> Agregar Imágenes
    </button>
</div>

<ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
    @foreach ($categorias_imagen as $categoria)
    <li class="nav-item" role="presentation">
        <button class="nav-link @if($loop->first) active @endif" id="tab-categoria-{{ $categoria }}" data-bs-toggle="tab" data-bs-target="#categoria-{{ $categoria }}"
            type="button" role="tab" aria-controls="categoria-{{ $categoria }}" aria-selected="false"
            onclick="cargarImagenes('{{ $categoria }}')">
            {{ ucfirst($categoria) }}
        </button>
    </li>
    @endforeach
</ul>

<!-- Contenedor donde se mostrarán las imágenes -->
<div class="tab-content mt-3" id="imagenes-content">
    <div id="imagenes" class="row g-4 justify-content-center">
        <p class="text-muted text-center">Seleccione una categoría para cargar las imágenes.</p>
    </div>
</div>

<script>
    function cargarImagenes(categoria) {
        const num_estacion = "{{ $estacion->num_estacion }}";

        // Limpiar el contenedor de imágenes anterior
        document.getElementById('imagenes').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>';

        // Hacer la solicitud AJAX
        $.ajax({
            url: `/galeria/${num_estacion}/${categoria}`,
            method: 'GET',
            success: function(imagenes) {
                const imagenesContainer = document.getElementById('imagenes');
                imagenesContainer.innerHTML = '';

                if (imagenes.length > 0) {
                    imagenes.forEach(function(imagen) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 col-sm-6 mb-3 text-center';

                        const imgCard = document.createElement('div');
                        imgCard.className = 'card shadow-sm';

                        const img = document.createElement('img');
                        img.src = imagen;
                        img.className = 'card-img-top';
                        img.alt = 'Imagen de categoría ' + categoria;
                        img.style.width = '100%'; // Asegura que la imagen ocupe todo el ancho del contenedor
                        img.style.height = 'auto'; // Mantiene la proporción sin distorsionar la imagen

                        const cardBody = document.createElement('div');
                        cardBody.className = 'card-body';

                        const deleteButton = document.createElement('button');
                        deleteButton.className = 'btn btn-danger btn-sm';
                        deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i> Eliminar';
                        deleteButton.onclick = function() {
                            eliminarImagen(imagen, categoria);
                        };

                        cardBody.appendChild(deleteButton);
                        imgCard.appendChild(img);
                        imgCard.appendChild(cardBody);
                        col.appendChild(imgCard);
                        imagenesContainer.appendChild(col);
                    });
                } else {
                    imagenesContainer.innerHTML = '<p class="text-center text-muted">No hay imágenes para esta categoría.</p>';
                }
            },
            error: function() {
                document.getElementById('imagenes').innerHTML = '<p class="text-center text-danger">Error al cargar las imágenes.</p>';
            }
        });
    }

    function eliminarImagen(imagen, categoria) {
        const num_estacion = "{{ $estacion->num_estacion }}";

        if (confirm('¿Estás seguro de que deseas eliminar esta imagen?')) {
            $.ajax({
                url: `/galeria/${num_estacion}/${categoria}/eliminar`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    imagen: imagen
                },
                success: function(response) {
                    alert(response.message);
                    cargarImagenes(categoria);
                },
                error: function() {
                    alert('Error al eliminar la imagen.');
                }
            });
        }
    }
</script>

@include('armonia.estacion.partials.guardar-imagen-modal')
@endsection