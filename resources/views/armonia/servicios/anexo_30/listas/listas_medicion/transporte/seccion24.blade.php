<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- TERCER BLOQUE DE REQUISITOS -->

                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                                4. Análisis y evaluación de la operación del sistema de medición:

                            </th>
                        </tr>

                        <tr class="table">
                            <th scope="row" colspan="100%">
                                El proveedor del servicio de verificación debe analizar y evaluar, si la operación del sistema de medición se lleva a cabo de acuerdo a las referencias normativas listadas en el apartado 30.7. del Anexo 30 de la RMF, y/o a los manuales y recomendaciones del fabricante. Este análisis y evaluación debe incluir:
                            </th>
                        </tr>


                        <!-- PRIMER BLOQUE DE REQUISITOS -->
                        <tr>
                            <td class="align-middle">
                                i. La periodicidad con que los elementos primarios y secundarios utilizados son verificados y calibrados contra estándares de referencia.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_periodicidad_primarios_secundarios" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="analisis_periodicidad_primarios_secundarios" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_periodicidad_primarios_secundarios" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_analisis_periodicidad_primarios_secundarios" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                ii. La concordancia entre el intervalo de medición calibrado de los elementos primarios y secundarios y los intervalos de medición de la operación del proceso.

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_concordancia_medicion_calibrado" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="analisis_concordancia_medicion_calibrado" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_concordancia_medicion_calibrado" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_analisis_concordancia_medicion_calibrado" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                iii. La compatibilidad, integridad y calidad de los tipos de señales de comunicación entre los elementos primarios y secundarios con el elemento terciario (computador de flujo o volumen).
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_compatiblidad_calidad_comunicacion" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="analisis_compatiblidad_calidad_comunicacion" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_compatiblidad_calidad_comunicacion" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por el tipo de instalación</strong>
                                <input type="hidden" name="observaciones_analisis_compatiblidad_calidad_comunicacion" value="No aplica por el tipo de instalación">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                iv. El apego a las normas o estándares de las ecuaciones de cálculo utilizadas por los elementos terciarios.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_apego_normas" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="analisis_apego_normas" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_apego_normas" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por el tipo de instalación</strong>
                                <input type="hidden" name="observaciones_analisis_apego_normas" value="No aplica por el tipo de instalación">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                v. La correspondencia del sistema de unidades utilizado en el cálculo de volúmenes.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_correspondencia_sistema" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="analisis_correspondencia_sistema" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_correspondencia_sistema" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por el tipo de instalación</strong>
                                <input type="hidden" name="observaciones_analisis_correspondencia_sistema" value="No aplica por el tipo de instalación">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                vi. Las condiciones base o de referencia utilizadas en el algoritmo de cálculo.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_condiciones_base" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="analisis_condiciones_base" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_condiciones_base" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por el tipo de instalación</strong>
                                <input type="hidden" name="observaciones_analisis_condiciones_base" value="No aplica por el tipo de instalación">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                vii. La cantidad de cifras significativas que se deben aplicar.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_cantidad_cifras" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="analisis_cantidad_cifras" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_cantidad_cifras" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por el tipo de instalación</strong>
                                <input type="hidden" name="observaciones_analisis_cantidad_cifras" value="No aplica por el tipo de instalación">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                viii. La validación del cálculo con respecto a un modelo matemático.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_validacion_calculo" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="analisis_validacion_calculo" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="analisis_validacion_calculo" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por el tipo de instalación</strong>
                                <input type="hidden" name="observaciones_analisis_validacion_calculo" value="No aplica por el tipo de instalación">
                            </td>
                        </tr>

                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>