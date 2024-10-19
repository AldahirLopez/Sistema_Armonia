@extends('layouts.master')

@section('title')
@lang('Estaciones de Servicio')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Seleccion @endslot
@slot('title') Estaciones de Servicio @endslot
@endcomponent

<div class="section-header" style="margin: 5px 5px 15px 5px;">
        <a href="{{ route('listas_medicion.seleccion', ['id' => $id_servicio]) }}" class="btn btn-danger">
            <i class="bi bi-arrow-return-left"></i> Volver
        </a>
</div>
<h4 style="padding-top: 40px;">Formulario para Estación de medicion</h4>
<!-- Formulario principal que envuelve todas las secciones -->
<form action="{{route('lista_inspeccion_medicion.store')}}" method="POST">
    @csrf
    <input type="hidden" id="id_servicio" value="{{ $id_servicio }}" name="id_servicio">
    <!-- Página 1 -->
    <div class="pagina" id="pagina-1">
        <div id="seccion01">
            {!! $seccion01 !!}
        </div>

        <div id="seccion02">
            {!! $seccion02 !!}
        </div>

        <div id="seccion03">
            {!! $seccion03 !!}
        </div>

        <!-- Botón para ir a la siguiente página -->
        <button type="button" class="btn btn-primary" onclick="mostrarPagina(2)">Siguiente</button>
    </div>

    <!-- Página 2 -->
    <div class="pagina" id="pagina-2" style="display:none;">
        <div id="seccion04">
            {!! $seccion04 !!}
        </div>

        <div id="seccion05">
            {!! $seccion05 !!}
        </div>

        <div id="seccion06">
            {!! $seccion06 !!}
        </div>

        <!-- Botones de navegación entre páginas -->
        <button type="button" class="btn btn-secondary" onclick="mostrarPagina(1)">Anterior</button>
        <button type="button" class="btn btn-primary" onclick="mostrarPagina(3)">Siguiente</button>
    </div>

    <!-- Página 3 -->
    <div class="pagina" id="pagina-3" style="display:none;">
        <div id="seccion07">
            {!! $seccion07 !!}
        </div>

        <div id="seccion08">
            {!! $seccion08 !!}
        </div>

        <div id="seccion09">
            {!! $seccion09 !!}
        </div>

        <!-- Botones de navegación entre páginas -->
        <button type="button" class="btn btn-secondary" onclick="mostrarPagina(2)">Anterior</button>
        <button type="button" class="btn btn-primary" onclick="mostrarPagina(4)">Siguiente</button>
    </div>

    <!-- Página 4 -->
    <div class="pagina" id="pagina-4" style="display:none;">
        <div id="seccion10">
            {!! $seccion10 !!}
        </div>

        <div id="seccion11">
            {!! $seccion11 !!}
        </div>

        <div id="seccion12">
            {!! $seccion12 !!}
        </div>

        <!-- Botones de navegación entre páginas -->
        <button type="button" class="btn btn-secondary" onclick="mostrarPagina(3)">Anterior</button>
        <button type="button" class="btn btn-primary" onclick="mostrarPagina(5)">Siguiente</button>
    </div>

    <!-- Página 5 -->
    <div class="pagina" id="pagina-5" style="display:none;">
        <div id="seccion13">
            {!! $seccion13 !!}
        </div>

        <div id="seccion14">
            {!! $seccion14 !!}
        </div>

        <div id="seccion15">
            {!! $seccion15 !!}
        </div>

        <div id="seccion16">
            {!! $seccion16 !!}
        </div>

        <div id="seccion17">
            {!! $seccion17 !!}
        </div>

        <div id="seccion18">
            {!! $seccion18 !!}
        </div>

        <div id="seccion19">
            {!! $seccion19 !!}
        </div>

        <div id="seccion20">
            {!! $seccion20 !!}
        </div>

        <div id="seccion21">
            {!! $seccion21 !!}
        </div>

        <div id="seccion22">
            {!! $seccion22 !!}
        </div>

        <div id="seccion23">
            {!! $seccion23 !!}
        </div>

        <div id="seccion24">
            {!! $seccion24 !!}
        </div>

        <div id="seccion25">
            {!! $seccion25 !!}
        </div>

        <div id="seccion26">
            {!! $seccion26 !!}
        </div>

        <div id="seccion27">
            {!! $seccion27 !!}
        </div>

        <!-- Botón para ir a la página anterior y finalizar -->
        <button type="button" class="btn btn-secondary" onclick="mostrarPagina(4)">Anterior</button>
        <button type="submit" class="btn btn-success">Finalizar</button>
    </div>
</form>

<script>
    const lista = @json($lista);
    
    function fillForm(json) {
        // Iterar sobre cada clave y valor en el objeto JSON
        for (const [key, value] of Object.entries(json)) {
            // Saltar la clave "tipo" y "tipo_general" ya que no son campos del formulario
            if (key === 'tipo' || key === 'tipo_general') continue;

            // Seleccionar y marcar el radio button si existe y coincide con el valor
            const radioButton = document.querySelector(`input[name="${key}"][value="${value}"]`);
            if (radioButton && radioButton.type === 'radio') {
                radioButton.checked = true;
            } else {
                // Seleccionar el campo de texto o textarea y asignar valor si existe
                const inputField = document.querySelector(`input[name="${key}"], textarea[name="${key}"]`);
                if (inputField && (inputField.type === 'text')) {
                    inputField.value = value; // Asigna el valor o vacío si es null
                }
            }
        }
    }

    // Llama a la función para rellenar el formulario
    fillForm(lista);
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