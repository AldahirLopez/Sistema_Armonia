<div class="mb-3">
    <label for="entidad_federativa_fiscal" class="form-label">Entidad Federativa</label>
    <select name="entidad_federativa_fiscal" id="entidad_federativa_fiscal" class="form-select">
        <option value="">Seleccionar estado</option>
        @foreach($estados as $estado)
        <option value="{{ $estado->id }}">{{ $estado->description }}</option>
        @endforeach
    </select>
</div>
<!-- Otros campos de la dirección -->
<div class="mb-3">
    <label for="entre_calles_fiscal" class="form-label">Entre Calles</label>
    <input type="text" name="entre_calles_fiscal" id="entre_calles_fiscal" class="form-control" placeholder="Entre Calles" required>
</div>

<div class="mb-3">
    <label for="calle_fiscal" class="form-label">Calle</label>
    <input type="text" name="calle_fiscal" id="calle_fiscal" class="form-control" placeholder="Calle" required>
</div>
 
<div class="mb-3">
    <label for="numero_ext_fiscal" class="form-label">Número Exterior</label>
    <input type="text" name="numero_ext_fiscal" id="numero_ext_fiscal" class="form-control" placeholder="Número Exterior" required>
</div>
 
<div class="mb-3">
    <label for="numero_int_fiscal" class="form-label">Número Interior</label>
    <input type="text" name="numero_int_fiscal" id="numero_int_fiscal" class="form-control" placeholder="Número Interior">
</div>

<div class="mb-3">
    <label for="colonia_fiscal" class="form-label">Colonia</label>
    <input type="text" name="colonia_fiscal" id="colonia_fiscal" class="form-control" placeholder="Colonia" required>
</div>

<div class="mb-3">
    <label for="codigo_postal_fiscal" class="form-label">Código Postal</label>
    <input type="text" name="codigo_postal_fiscal" id="codigo_postal_fiscal" class="form-control" placeholder="Código Postal" required>
</div>

<div class="mb-3">
    <label for="municipio_id_fiscal" class="form-label">Municipio</label>
    <select name="municipio_id_fiscal" id="municipio_id_fiscal" class="form-select" required>
        <option value="">Seleccionar municipio</option>
        <!-- Los municipios se cargarán dinámicamente según el estado seleccionado -->
    </select>
</div>

<div class="mb-3">
    <label for="localidad_fiscal" class="form-label">Localidad</label>
    <input type="text" name="localidad_fiscal" id="localidad_fiscal" class="form-control" placeholder="Localidad" required>
</div> 