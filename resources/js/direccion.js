document.addEventListener('DOMContentLoaded', function () {
    // Selección de estado y municipios para la creación y edición
    const estadoSelect = document.getElementById('entidad_federativa_fiscal');
    const municipioSelect = document.getElementById('municipio_id_fiscal');

    if (estadoSelect && municipioSelect) {
        estadoSelect.addEventListener('change', function () {
            const estadoId = this.value;

            // Limpiar el select de municipios
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
        });
    }

    // Editar Dirección Fiscal
    document.querySelectorAll('button[data-bs-target="#editFiscalModal"]').forEach(button => {
        button.addEventListener('click', function () {
            const direccionId = this.getAttribute('data-id');
            fetch(`/direccion/${direccionId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('direccion_id').value = data.id;
                    document.getElementById('calle_fiscal_edit').value = data.calle;
                    document.getElementById('numero_ext_fiscal_edit').value = data.numero_ext;
                    document.getElementById('numero_int_fiscal_edit').value = data.numero_int;
                    document.getElementById('colonia_fiscal_edit').value = data.colonia;
                    document.getElementById('codigo_postal_fiscal_edit').value = data.codigo_postal;

                    // Actualizar el estado y cargar los municipios correspondientes
                    const estadoSelectEdit = document.getElementById('entidad_federativa_fiscal_edit');
                    const municipioSelectEdit = document.getElementById('municipio_id_fiscal_edit');

                    estadoSelectEdit.value = data.entidad_federativa_id;
                    fetch(`/municipios/${data.entidad_federativa_id}`)
                        .then(response => response.json())
                        .then(municipios => {
                            municipioSelectEdit.innerHTML = '<option value="">Seleccionar municipio</option>';
                            municipios.forEach(municipio => {
                                const option = document.createElement('option');
                                option.value = municipio.description;
                                option.textContent = municipio.description;
                                if (municipio.description === data.municipio) {
                                    option.selected = true;
                                }
                                municipioSelectEdit.appendChild(option);
                            });
                        });
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    });

    // Editar Dirección de Estación
    document.querySelectorAll('button[data-bs-target="#editEstacionModal"]').forEach(button => {
        button.addEventListener('click', function () {
            const direccionId = this.getAttribute('data-id');
            fetch(`/direccion/${direccionId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('direccion_id_estacion').value = data.id;
                    document.getElementById('calle_estacion_edit').value = data.calle;
                    document.getElementById('numero_ext_estacion_edit').value = data.numero_ext;
                    document.getElementById('numero_int_estacion_edit').value = data.numero_int;
                    document.getElementById('colonia_estacion_edit').value = data.colonia;
                    document.getElementById('codigo_postal_estacion_edit').value = data.codigo_postal;

                    // Actualizar el estado y cargar los municipios correspondientes
                    const estadoSelectEdit = document.getElementById('entidad_federativa_estacion_edit');
                    const municipioSelectEdit = document.getElementById('municipio_id_estacion_edit');

                    estadoSelectEdit.value = data.entidad_federativa_id;
                    fetch(`/municipios/${data.entidad_federativa_id}`)
                        .then(response => response.json())
                        .then(municipios => {
                            municipioSelectEdit.innerHTML = '<option value="">Seleccionar municipio</option>';
                            municipios.forEach(municipio => {
                                const option = document.createElement('option');
                                option.value = municipio.description;
                                option.textContent = municipio.description;
                                if (municipio.description === data.municipio) {
                                    option.selected = true;
                                }
                                municipioSelectEdit.appendChild(option);
                            });
                        });
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    });
});
