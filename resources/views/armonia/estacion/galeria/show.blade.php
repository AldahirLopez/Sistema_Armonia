@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Estaciones @endslot
@slot('title') Galeria @endslot
@endcomponent

@include('partials.alertas') <!-- Incluyendo las alertas -->

    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#storeImage" data-bs-placement="top" title="Editar estación">
        <i class="fas fa-plus"></i>Agregar imagenes
    </button>


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

    <script>
    function cargarImagenes(categoria) {
    
    // Asumiendo que tienes el ID o número de la estación en una variable
    const num_estacion = "{{ $estacion->num_estacion }}"; // O ajusta según cómo accedas a la estación

    // Limpiar el contenedor de imágenes anterior
    document.getElementById('imagenes').innerHTML = '';

    // Hacer la solicitud AJAX
    $.ajax({
        url: `/galeria/${num_estacion}/${categoria}`, // Usar el num_estacion en la URL
        method: 'GET',
        success: function(imagenes) {
            if (imagenes.length > 0) {
                // Recorrer las imágenes y agregarlas al contenedor
                imagenes.forEach(function(imagen) {
                   
                    const col = document.createElement('div');
                    col.className = 'col-md-3'; 
                    const img = document.createElement('img');
                    img.src = imagen;
                    img.className = 'img-fluid'; 

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

    </script>




@include('armonia.estacion.partials.guardar-imagen-modal')             
@endsection