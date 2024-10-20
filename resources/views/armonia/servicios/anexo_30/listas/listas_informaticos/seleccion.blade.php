@extends('layouts.master')

@section('title')
@lang('Lista de inspeccion')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Seleccion @endslot
@slot('title') Lista de inspección verificación de programas informáticos @endslot
@endcomponent

@include('partials.alertas') <!-- Incluyendo las alertas -->
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between">
            <a href="{{ route('armonia.servicios.anexo_30.listas_inspeccion.menu', ['id' => $id_servicio]) }}" class="btn btn-danger">
                
                <i class="bi bi-arrow-return-left"></i> Volver
            </a>
                
            </div>
        </div>
    </div>
</div>

    @if ($listas_inspeccion)

    <div class="row">
     
        <div class="col-lg-4 col-md-6 mb-4 d-flex">
            <div class="card border-light shadow-sm h-100 w-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title font-weight-bold text-dark text-truncate">
                        Lista de inspeccion del servicio {{ $listas_inspeccion->servicio_anexo->nomenclatura}}
                        
                    </h5>
                </div>

                <div class="card-body d-flex flex-column justify-content-between">
                    <!-- Estado de la lista de inspeccion -->
                    <p class="text-muted">                  
                        <span class="badge bg-success">Generada</span> 
                    </p>

                    <!-- Mostrar las estaciones relacionadas con el servicio -->
                    <p class="card-text text-muted mb-3">
                        Tipo de lista:
                        @if($listas_inspeccion->servicio_anexo)
                            {{$listas_inspeccion->lista['tipo_lista']}}
                        @else
                        Desconocido
                        @endif
                    </p>

                
                    <div class="d-flex justify-content-end align-items-center mt-auto">                        
                       
                            <form action="{{ route('lista_inspeccion.destroy',['id'=>$listas_inspeccion->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar la lista?');"> <i class="bx bx-trash"></i></button>
                            </form> 
                        
                        <!-- Mostrar botón de editar solo si el usuario tiene el rol de 'Administrador' -->
                        @if(auth()->user()->hasRole('Administrador'))
                        <a href="{{route('lista_inspeccion.edit',['id'=>$listas_inspeccion->id])}}" class="btn btn-outline-primary btn-sm ms-2 d-inline-flex align-items-center">
                            <i class="bx bx-edit me-1" style="font-size: 1.2rem;"></i> <!-- Icono de editar con tamaño mayor -->
                            <span>Editar</span>
                        </a>                        
                        @endif

                        @if(auth()->user()->hasRole('Administrador'))
                        <a href="{{route('lista_inspeccion.descargar_pdf',['id_lista'=>$listas_inspeccion->id])}}" class="btn btn-outline-danger btn-sm" title="Descargar como PDF">
                            <i class="fas fa-file-pdf fa-2x"></i>
                            
                        </a> 

                        <a href="{{route('lista_inspeccion.descargar_word',['id_lista'=>$listas_inspeccion->id])}}" class="btn btn-outline-primary btn-sm" title="Descargar en Word">
                            <i class="fas fa-file-word fa-2x"></i>
                            
                        </a>
                        
                        
                        @endif


                    </div>

                    
                </div>
            </div>
        </div>  
    </div>

    
    @else
    <form action="">
        <select id="tipo" name="tipo" class="form-select">
            <option selected disabled>Selecciona el tipo</option>
            <option value="estacion">Estación</option>
            <option value="transporte">Transporte</option>
            <option value="almacenamiento">Almacenamiento</option>
        </select>
    </form>
    @endif

    
</div>
<input type="hidden" id="id_servicio" value="{{ $id_servicio }}">

<div id="form-container"></div>

<script>
    document.getElementById('tipo').addEventListener('change', function() {
        var selectedValue = this.value;
        var idServicio = document.getElementById('id_servicio').value; // Get the id_servicio value
        if (selectedValue && idServicio) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/form/' + selectedValue + '/' + idServicio, true); // Pass both type and id_servicio
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