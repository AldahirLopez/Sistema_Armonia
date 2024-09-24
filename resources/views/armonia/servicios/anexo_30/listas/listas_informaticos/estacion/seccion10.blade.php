<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- TERCER BLOQUE DE REQUISITOS -->

                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                                d) Dispensarios:

                            </th>
                        </tr>


                        <!-- PRIMER BLOQUE DE REQUISITOS -->
                        <tr>
                            <td class="align-middle">
                                1. Clave de identificación.
                                Ejemplos:
                                DISP-0004. Se emplea para identificar el dispensario de una estación de
                                servicio.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_identificacion_dispensarios" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="clave_identificacion_dispensarios" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_identificacion_dispensarios" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_clave_identificacion_dispensarios" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                2. Sistemas de medición. Se deben registrar los sistemas de medición
                                instalados en cada dispensario asignándoles una clave y registrando su
                                descripción o localización, vigencia de calibración e incertidumbre de
                                medición.


                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="sistema_medicion_dispensario" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="sistema_medicion_dispensario" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="sistema_medicion_dispensario" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_sistema_medicion_dispensario" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                                3. Mangueras.
                                Ejemplo:
                                DISP-0004-MGA-0002. Se emplea para identificar una manguera.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="mangueras" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="mangueras" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="mangueras" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_mangueras" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                                4. Entregas.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="entregas_dispensario" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="entregas_dispensario" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="entregas_dispensario" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_entregas_dispensario" class="form-control">
                            </td>
                        </tr>

                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>