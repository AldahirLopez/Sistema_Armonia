<h4 style="padding-top: 40px;">Formulario para Estación</h4>
<!-- Formulario principal que envuelve todas las secciones -->
<form action="{{route('lista_inspeccion.store')}}" method="POST">
    @csrf

    <!-- Cargar Sección 1 -->
    <div id="seccion01">
        {!! $seccion01 !!}
    </div>

    <!-- Cargar Sección 2 -->
    <div id="seccion02">
        {!! $seccion02 !!}
    </div>

    <!-- Cargar Sección 3 -->
    <div id="seccion03">
        {!! $seccion03 !!}
    </div>

    <!-- Cargar Sección 4 -->
    <div id="seccion04">
        {!! $seccion04 !!}
    </div>
    
    <!-- Cargar Sección 4 -->
    <div id="seccion05">
        {!! $seccion05 !!}
    </div>

    <!-- Cargar Sección 4 -->
    <div id="seccion06">
        {!! $seccion06 !!}
    </div>

    <!-- Cargar Sección 4 -->
    <div id="seccion07">
        {!! $seccion07 !!}
    </div>

    <div id="seccion08">
        {!! $seccion08 !!}
    </div>

    <div id="seccion09">
        {!! $seccion09 !!}
    </div>

    <div id="seccion10">
        {!! $seccion10 !!}
    </div>

    <div id="seccion11">
        {!! $seccion11 !!}
    </div>


    <div id="seccion12">
        {!! $seccion12 !!}
    </div>

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
   
   
    <!-- Botones de navegación -->
    <div class="form-navigation mt-4">
        <button type="submit" class="btn btn-success">Finalizar</button>
    </div>
</form>