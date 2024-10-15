<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- TERCER BLOQUE DE REQUISITOS -->
                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                                d) Terminales de almacenamiento y áreas de almacenamiento para usos propios:
                            </th>
                        </tr>
                        <!-- PRIMER BLOQUE DE REQUISITOS -->
                        <tr>
                            <td class="align-middle">
                                En las terminales de almacenamiento, así como en las áreas de almacenamiento para usos propios, el sistema de medición se debe implementar para generar los registros del volumen de las operaciones de recepción, entrega y control de existencias de los Hidrocarburos o Petrolíferos de que se trate.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="terminales_almacenamiento_sistema_medicion" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="terminales_almacenamiento_sistema_medicion" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="terminales_almacenamiento_sistema_medicion" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por ser una estación de servicio</strong>
                                <input type="hidden" name="observaciones_terminales_almacenamiento_sistema_medicion" value="No aplica por ser una estación de servicio">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                Las operaciones de recepción que se realicen en las terminales de almacenamiento o en las áreas de almacenamiento para usos propios, deben corresponder a los volúmenes recibidos por algún medio de transporte o distribución.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="operaciones_recepcion_volumenes_recibidos" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="operaciones_recepcion_volumenes_recibidos" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="operaciones_recepcion_volumenes_recibidos" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por ser una estación de servicio</strong>
                                <input type="hidden" name="observaciones_operaciones_recepcion_volumenes_recibidos" value="No aplica por ser una estación de servicio">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                Las operaciones de entrega que se realicen en las terminales de almacenamiento deben corresponder a los volúmenes transferidos a través de algún medio de transporte o distribución.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="operaciones_entrega_volumenes_trasnferidos" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="operaciones_entrega_volumenes_trasnferidos" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="operaciones_entrega_volumenes_trasnferidos" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por ser una estación de servicio</strong>
                                <input type="hidden" name="observaciones_operaciones_entrega_volumenes_trasnferidos" value="No aplica por ser una estación de servicio">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                Se deben instalar medidores dinámicos en los ductos de entrada y salida al (a los) medio(s) de almacenamiento y medidor(es) estático(s) en el (los) medio(s) de almacenamiento.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medidores_dinamicos_terminales" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="medidores_dinamicos_terminales" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medidores_dinamicos_terminales" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por ser una estación de servicio</strong>
                                <input type="hidden" name="observaciones_medidores_dinamicos_terminales" value="No aplica por ser una estación de servicio">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                Se deben seleccionar los medidores conforme a los requisitos metrológicos: características de los fluidos, intervalos de medición y condiciones operativas del proceso.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medidores_terminales_metrologicos" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="medidores_terminales_metrologicos" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medidores_terminales_metrologicos" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por ser una estación de servicio</strong>
                                <input type="hidden" name="observaciones_medidores_terminales_metrologicos" value="No aplica por ser una estación de servicio">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                Los medidores estáticos deben cumplir con la normatividad descrita en el apartado 30.7., fracciones I y II, que les corresponda, así como VI, señalados en este Anexo.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medidores_estaticos_terminales_apartado" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="medidores_estaticos_terminales_apartado" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medidores_estaticos_terminales_apartado" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por ser una estación de servicio</strong>
                                <input type="hidden" name="observaciones_medidores_estaticos_terminales_apartado" value="No aplica por ser una estación de servicio">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                Los medidores dinámicos deben cumplir con la normatividad que les corresponda descrita en el apartado 30.7., fracciones I y VI, así como III para el petróleo o, IV para el gas natural, señalados en este Anexo.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medidores_dinamicos_terminales_apartado" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="medidores_dinamicos_terminales_apartado" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medidores_dinamicos_terminales_apartado" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por ser una estación de servicio</strong>
                                <input type="hidden" name="observaciones_medidores_dinamicos_terminales_apartado" value="No aplica por ser una estación de servicio">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                Tratándose de las operaciones de recepción y entrega de gas natural licuado en terminales de almacenamiento, de parte de personas que operen un medio de transporte que no se ubiquen en los supuestos a que se refiere la regla 2.6.1.2., fracción IV, la información del volumen se debe obtener de un sistema de medición que cumpla con la normatividad descrita en el apartado 30.7., fracciones II y VI de un tercero que cuente con acreditación emitida en términos de la LFMN, LIC o cualquier otra entidad reconocida internacionalmente.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="operaciones_recepcion_entrega_gas_natural" value="si" disabled> Sí
                                </label>
                                <label>
                                    <input type="radio" name="operaciones_recepcion_entrega_gas_natural" value="no" disabled> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="operaciones_recepcion_entrega_gas_natural" value="no_aplica" checked> No Aplica
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <strong>No Aplica por ser una estación de servicio</strong>
                                <input type="hidden" name="observaciones_operaciones_recepcion_entrega_gas_natural" value="No aplica por ser una estación de servicio">
                            </td>
                        </tr>

                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>