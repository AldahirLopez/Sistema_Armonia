@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Seleccion @endslot
@slot('title') Estaciones de Servicio @endslot
@endcomponent

<div class="section-header">
    <div class="section-header" style="margin: 5px 5px 15px 5px;">
        <a href="{{ route('anexo.index', ['id' => $id_servicio]) }}" class="btn btn-danger">
            <i class="bi bi-arrow-return-left"></i> Volver
        </a>
    </div>
    <h3 class="page__heading">Lista de Inspección</h3>

    <form action="">
        <select id="tipo" name="tipo" class="form-select">
            <option selected disabled>Selecciona el tipo</option>
            <option value="estacion">Estación</option>
            <option value="transporte">Transporte</option>
            <option value="almacenamiento">Almacenamiento</option>
        </select>
    </form>
</div>
<div id="form-container"></div>

<script>
    document.getElementById('tipo').addEventListener('change', function() {
        var selectedValue = this.value;
        if (selectedValue) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/form/' + selectedValue, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('form-container').innerHTML = xhr.responseText;
                    document.getElementById('form-container').style.display = 'block';
                } else {
                    console.error('Error al cargar el formulario');
                }
            };
            xhr.send();
        } else {
            document.getElementById('form-container').innerHTML = '';
            document.getElementById('form-container').style.display = 'none';
        }
    });
</script>
<script>
    function mostrarPagina(numeroPagina) {
        //console.log('Mostrando página:', numeroPagina); // Añadir este log para depurar
        // Ocultar todas las páginas
        const paginas = document.querySelectorAll('.pagina');
        paginas.forEach(pagina => {
            pagina.style.display = 'none';
        });

        // Mostrar la página seleccionada
        document.getElementById('pagina-' + numeroPagina).style.display = 'block';
    }
</script>
@endsection