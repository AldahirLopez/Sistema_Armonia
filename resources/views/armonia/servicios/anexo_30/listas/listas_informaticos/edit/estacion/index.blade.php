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
        <a href="{{ route('listas.seleccion', ['id' => $id_servicio]) }}" class="btn btn-danger">
            <i class="bi bi-arrow-return-left"></i> Volver
        </a>
</div>
<h4 style="padding-top: 40px;">Formulario para Estación</h4>
<!-- Formulario principal que envuelve todas las secciones -->
<form action="{{route('lista_inspeccion.store')}}" method="POST">
    @csrf
    
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

        <!-- Botón para ir a la página anterior y finalizar -->
        <button type="button" class="btn btn-secondary" onclick="mostrarPagina(4)">Anterior</button>
        <button type="submit" class="btn btn-success">Finalizar</button>
    </div>
</form>
<script>
  
    const lista = @json($lista);
    function fillForm(json) {
        if (json.seccion1) {
            const respaldoRadio = document.querySelector(`input[name="respaldo"][value="${json.seccion1.respaldo}"]`);
            if (respaldoRadio) {
                respaldoRadio.checked = true;  
            }
            const observacionesRespaldo = document.querySelector('input[name="observaciones_respaldo"]');
            if (observacionesRespaldo) {
                observacionesRespaldo.value = json.seccion1.observaciones_respaldo;
            }


            const entorno_visual = document.querySelector(`input[name="entorno_visual"][value="${json.seccion1.entorno_visual}"]`);
            if (entorno_visual) {
                entorno_visual.checked = true;  
            }
            const observaciones_entorno_visual = document.querySelector('input[name="observaciones_entorno_visual"]');
            if (observaciones_entorno_visual) {
                observaciones_entorno_visual.value = json.seccion1.observaciones_entorno_visual;
            }


            const control_acceso = document.querySelector(`input[name="control_acceso"][value="${json.seccion1.control_acceso}"]`);
            if (control_acceso) {
                control_acceso.checked = true;  
            }
            const observaciones_control_acceso = document.querySelector('input[name="observaciones_control_acceso"]');
            if (observaciones_control_acceso) {
                observaciones_control_acceso.value = json.seccion1.observaciones_control_acceso;
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