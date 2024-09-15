document.addEventListener('DOMContentLoaded', function () {
    // Función para cargar municipios según el estado seleccionado
    function cargarMunicipios(estadoId, municipioSelect) {
        municipioSelect.innerHTML = '<option value="">Seleccionar municipio</option>';
        if (estadoId) {
            fetch(`/municipios/${estadoId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(municipio => {
                        const option = document.createElement('option');
                        option.value = municipio.description;
                        option.textContent = municipio.description;
                        municipioSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar municipios:', error));
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        function cargarDatosEnModal(button, modalPrefix) {
            const id = button.getAttribute('data-id');
            const entidadFederativa = button.getAttribute('data-entidad_federativa');
            const municipio = button.getAttribute('data-municipio');
            const calle = button.getAttribute('data-calle');
            const entreCalles = button.getAttribute('data-entre_calles');
            const numeroExterior = button.getAttribute('data-numero_exterior');
            const numeroInterior = button.getAttribute('data-numero_interior');
            const colonia = button.getAttribute('data-colonia');
            const codigoPostal = button.getAttribute('data-codigo_postal');
            const localidad = button.getAttribute('data-localidad');

            // Asignar los datos al formulario del modal
            document.getElementById(`${modalPrefix}_id`).value = id;
            document.getElementById(`${modalPrefix}_entidad_federativa_edit`).value = entidadFederativa;
            document.getElementById(`${modalPrefix}_municipio_edit`).value = municipio;
            document.getElementById(`${modalPrefix}_calle_edit`).value = calle;
            document.getElementById(`${modalPrefix}_entre_calles_edit`).value = entreCalles;
            document.getElementById(`${modalPrefix}_numero_ext_edit`).value = numeroExterior;
            document.getElementById(`${modalPrefix}_numero_int_edit`).value = numeroInterior;
            document.getElementById(`${modalPrefix}_colonia_edit`).value = colonia;
            document.getElementById(`${modalPrefix}_codigo_postal_edit`).value = codigoPostal;
            document.getElementById(`${modalPrefix}_localidad_edit`).value = localidad;
 
            // Actualizar el 'action' del formulario con el id correcto
            const form = document.getElementById(`${modalPrefix}Form`);
            form.action = `/direcciones/${id}`;
        }

        // Inicialización de los modales
        document.querySelectorAll('button[data-bs-target="#editEstacionModal"]').forEach(button => {
            button.addEventListener('click', function () {
                cargarDatosEnModal(button, 'direccion_estacion');
            });
        });

        document.querySelectorAll('button[data-bs-target="#editFiscalModal"]').forEach(button => {
            button.addEventListener('click', function () {
                cargarDatosEnModal(button, 'direccion_fiscal');
            });
        });
    });



    // Selección de estado y municipios para la creación
    const estadoSelect = document.getElementById('entidad_federativa_fiscal');
    const municipioSelect = document.getElementById('municipio_fiscal');

    if (estadoSelect && municipioSelect) {
        estadoSelect.addEventListener('change', function () {
            cargarMunicipios(this.value, municipioSelect);
        });
    }
});
