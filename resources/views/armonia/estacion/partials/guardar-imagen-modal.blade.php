<!-- Modal -->
<div class="modal fade" id="storeImage" tabindex="-1" aria-labelledby="storeImage" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="generarExpedienteModalLabel">Imagenes de la estacion {{$estacion->razon_social}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
            <form id="storeImage" action="{{route('galeria.store',['estacion'=>$estacion])}}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Campos ocultos -->
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <div class="form-group">
                                <select name="categoria" id="categoria" class="form-select" required>
                                <option value="" disabled selected>Seleccione la categoria</option>
                                    @foreach ($categorias_imagen as $categoria)
                                        <option value="{{$categoria}}">{{$categoria}}</option>
                                    @endforeach
                                </select>
                        </div>
                    
                    </div>
                </div>

                <div class="row">
                    <!-- Sección para subir varias imágenes -->
                    <div class="col-md-12">                     
                        <div class="form-group">
                            <label for="imagenes">Subir Imágenes</label>
                            <input type="file" name="imagenes[]" class="form-control" id="imagenes" accept="image/*" multiple required>
                            <small class="form-text text-muted">Debe subir al menos 4 imágenes.De lo contrario no se actualizara su reporte</small>
                        </div>
                    </div>
                </div>
                <!-- Botón para enviar el formulario -->
                <button type="submit" class="btn btn-primary mt-3">Subir</button>
            </form>
            </div>
        </div>
    </div>
</div> 