<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- SEGUNDO BLOQUE DE REQUISITOS -->
                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                                III. Los sistemas de medición deben instalarse en los siguientes puntos:
                            </th>
                        </tr>

                        <tr class="table">
                            <th scope="row" colspan="100%">
                                a) Áreas contractuales y asignaciones
                            </th>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                Punto de medición aprobado, o en su caso determinado por la CNH, en
                                donde se llevará a cabo la medición del volumen de los Hidrocarburos
                                producidos al amparo de un contrato o Asignación.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="punto_medicion_aprobado_CNH" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="punto_medicion_aprobado_CNH" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="punto_medicion_aprobado_CNH" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por el tipo de instalación</strong>
                                <input type="hidden" name="observaciones_punto_medicion_aprobado_CNH" value="No aplica por el tipo de instalación">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                Se debe seleccionar el medidor conforme a los requisitos metrológicos:
                                características de los fluidos, intervalos de medición y condiciones técnicas
                                u operativas del proceso. En caso de emplearse, el medidor multifásico debe
                                cumplir con la normatividad descrita en el apartado 30.7., fracciones I, V y
                                VI, señalados en este Anexo.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="seleccion_medidor_metrologicos" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="seleccion_medidor_metrologicos" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="seleccion_medidor_metrologicos" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por el tipo de instalación</strong>
                                <input type="hidden" name="observaciones_seleccion_medidor_metrologicos" value="No aplica por el tipo de instalación">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                Se deben realizar registros de la producción diaria y la producción acumulada mensual.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="registro_produccion_diaria_acumulada_mensual" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="registro_produccion_diaria_acumulada_mensual" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="registro_produccion_diaria_acumulada_mensual" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por el tipo de instalación</strong>
                                <input type="hidden" name="observaciones_registro_produccion_diaria_acumulada_mensual" value="No aplica por el tipo de instalación">
                            </td>
                        </tr>

                        <!-- Continúa con el resto de requisitos de la tabla de forma similar -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>