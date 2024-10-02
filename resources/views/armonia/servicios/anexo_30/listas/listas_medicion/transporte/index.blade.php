<h4 style="padding-top: 40px;">Formulario para Transporte</h4>
<!-- Formulario principal que envuelve todas las secciones -->
<form action="{{route('lista_inspeccion.store')}}" method="POST">
    @csrf
    <input type="hidden" id="id_servicio" value="{{ $id_servicio }}" name="id_servicio">
    <input type="hidden" id="tipo_lista" value="{{ $tipo }}" name="tipo_lista">
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