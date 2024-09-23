


<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">REQUISITO DE LOS ANEXOS 30 Y 31 DE LA RESOLUCIÓN MISCELÁNEA FISCAL PARA 2023</th>
                            <th class="text-center align-middle">CUMPLE</th>
                            <th class="text-center align-middle">NO APLICA</th>
                            <th class="text-center align-middle">OBSERVACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- PRIMER BLOQUE DE REQUISITOS -->
                        <tr>
                            <td class="align-middle">
                                I. Los programas informáticos y cualquier información que se recopile o procese a través de éstos y esté relacionada con los controles volumétricos, deben encontrarse respaldados en medios magnéticos, ópticos, de estado sólido o de cualquier otra tecnología segura en una UCC.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="respaldo" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="respaldo" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="respaldo" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_respaldo" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                II. El programa informático debe proporcionar un entorno visual sencillo para permitir su operación.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="entorno_visual" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="entorno_visual" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="entorno_visual" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_entorno_visual" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                III. El inicio de sesión debe tener implementado un control de acceso, que solicite usuario y contraseña, con el propósito de impedir el acceso a personas no autorizadas.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="control_acceso" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="control_acceso" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="control_acceso" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_control_acceso" class="form-control">
                            </td>
                        </tr>
                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>


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